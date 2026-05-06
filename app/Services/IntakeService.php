<?php

namespace App\Services;

use App\Models\IntakeAnswer;
use App\Models\IntakeForm;
use App\Models\IntakeOption;
use App\Models\IntakeQuestion;
use App\Models\Patient;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class IntakeService
{
    private array $specializations = [
        'stress'    => 'Stress Management',
        'anxiety'   => 'Anxiety & Panic Disorders',
        'sleep'     => 'Sleep Disorders',
        'mood'      => 'Depression & Mood Disorders',
        'social'    => 'Social & Relationship Therapy',
        'trauma'    => 'Trauma & PTSD',
        'self_care' => 'Behavioral & Lifestyle Therapy',
    ];

    /**
     * Submit intake answers for a patient, calculate scores, create form and report.
     *
     * @param  int   $patientId
     * @param  array $answers  [['question_id' => x, 'option_id' => y], ...]
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Throwable
     */
    public function submit(int $patientId, array $answers): array
    {
        $patient = Patient::findOrFail($patientId);

        return DB::transaction(function () use ($patient, $answers) {
            $scores = array_fill_keys(array_keys($this->specializations), 0);

            foreach ($answers as $answer) {
                $option   = IntakeOption::findOrFail($answer['option_id']);
                $question = IntakeQuestion::findOrFail($answer['question_id']);

                IntakeAnswer::create([
                    'patient_id'         => $patient->id,
                    'intake_question_id' => $question->id,
                    'intake_option_id'   => $option->id,
                    'score'              => $option->score,
                ]);

                if (isset($scores[$question->category])) {
                    $scores[$question->category] += $option->score;
                }
            }

            $totalScore   = array_sum($scores);
            $overallLevel = $this->calculateLevel($totalScore);
            $recommended  = $this->getRecommendedSpecializations($scores);

            $intakeForm = IntakeForm::create([
                'patient_id'                 => $patient->id,
                'stress_score'               => $scores['stress'],
                'anxiety_score'              => $scores['anxiety'],
                'sleep_score'                => $scores['sleep'],
                'mood_score'                 => $scores['mood'],
                'social_score'               => $scores['social'],
                'trauma_score'               => $scores['trauma'],
                'self_care_score'            => $scores['self_care'],
                'overall_level'              => $overallLevel,
                'recommended_specialization' => $recommended[0] ?? 'General Therapy',
            ]);

            $patient->update(['condition_level' => $overallLevel]);

            $report = Report::create([
                'patient_id'                 => $patient->id,
                'therapist_id'               => $patient->therapist_id,
                'intake_form_id'             => $intakeForm->id,
                'total_score'                => $totalScore,
                'condition_level'            => $overallLevel,
                'recommended_specialization' => $recommended[0] ?? 'General Therapy',
            ]);

            return [
                'intake_form'  => $intakeForm,
                'report'       => $report,
                'scores'       => $scores,
                'total_score'  => $totalScore,
                'recommended'  => $recommended,
                'overall_level' => $overallLevel,
            ];
        });
    }

    private function calculateLevel(int $total): string
    {
        return match (true) {
            $total <= 40  => 'low',
            $total <= 70  => 'medium',
            $total <= 100 => 'high',
            default       => 'severe',
        };
    }

    private function getRecommendedSpecializations(array $scores): array
    {
        if (empty($scores)) {
            return ['General Therapy'];
        }

        $maxScore = max($scores);

        if ($maxScore === 0) {
            return ['General Therapy'];
        }

        $topCategories = array_keys(array_filter($scores, fn($s) => $s === $maxScore));

        return array_map(
            fn($cat) => $this->specializations[$cat] ?? 'General Therapy',
            $topCategories
        );
    }
}
