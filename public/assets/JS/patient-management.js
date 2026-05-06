var avatarColors = [
  "av-teal",
  "av-purple",
  "av-amber",
  "av-coral",
  "av-blue",
  "av-pink"
];
//test
var allPatients = [
  {
    id: 1,
    name: "Sara Ahmed",
    initials: "SA",
    age: 28,
    sessions: 12,
    reports: [
      { date: "Apr 28, 2026", text: "Patient reports improved sleep. CBT worksheet completed. Mood elevated compared to last session.", tag: "Progress" },
      { date: "Apr 14, 2026", text: "Discussed anxiety triggers at work. Assigned breathing exercises for daily use.", tag: "Homework assigned" },
      { date: "Mar 31, 2026", text: "Initial deep dive into thought patterns. Patient engaged and responsive.", tag: "Assessment" }
    ]
  },
  {
    id: 2,
    name: "Omar Khalil",
    initials: "OK",
    age: 34,
    sessions: 7,
    reports: [
      { date: "Apr 30, 2026", text: "Significant reduction in panic attacks. Patient using grounding techniques effectively.", tag: "Progress" },
      { date: "Apr 16, 2026", text: "Explored childhood patterns. Emotional session, patient coped well.", tag: "Deep work" }
    ]
  },
  {
    id: 3,
    name: "Nour El-Din",
    initials: "ND",
    age: 22,
    sessions: 3,
    reports: [
      { date: "May 1, 2026", text: "First full session. Patient hesitant but opened up by end. Trust-building priority.", tag: "Early stage" }
    ]
  },
  {
    id: 4,
    name: "Layla Hassan",
    initials: "LH",
    age: 41,
    sessions: 18,
    reports: [
      { date: "Apr 25, 2026", text: "Long-term patient showing strong self-awareness. Transitioning to biweekly sessions.", tag: "Milestone" },
      { date: "Apr 11, 2026", text: "Reviewed relapse prevention plan. Patient confident in coping strategies.", tag: "Review" },
      { date: "Mar 28, 2026", text: "Addressed grief resurgence. Validated feelings, introduced journaling prompt.", tag: "Grief work" }
    ]
  },
  {
    id: 5,
    name: "Youssef Nasser",
    initials: "YN",
    age: 30,
    sessions: 5,
    reports: [
      { date: "Apr 29, 2026", text: "Mood slightly lower this week. Explored stressors at home. Adjusted homework.", tag: "Check-in" },
      { date: "Apr 15, 2026", text: "Good session — patient identified two core negative beliefs. Working on reframing.", tag: "CBT" }
    ]
  },
  {
    id: 6,
    name: "Dina Mostafa",
    initials: "DM",
    age: 26,
    sessions: 9,
    reports: [
      { date: "May 2, 2026", text: "Patient reports reduced social anxiety. Attended a group event — first time in months.", tag: "Breakthrough" }
    ]
  },
  {
    id: 7,
    name: "Dina Mostafa",
    initials: "DM",
    age: 26,
    sessions: 9,
    reports: [
      { date: "May 2, 2026", text: "Patient reports reduced social anxiety. Attended a group event — first time in months.", tag: "Breakthrough" }
    ]
  },
  {
    id: 8,
    name: "Ganna Khalled",
    initials: "GK",
    age: 26,
    sessions: 9,
    reports: [
      { date: "May 2, 2026", text: "Patient reports reduced social anxiety. Attended a group event — first time in months.", tag: "Breakthrough" }
    ]
  }
];

renderCards(allPatients);
//end el test

/*
var allPatients = [];

fetch("/api/therapist/patients")
  .then(function(res) { return res.json(); })
  .then(function(data) {
    allPatients = data;
    renderCards(allPatients);
  })
  .catch(function(err) {
    console.error("Failed to load patients:", err);
    document.getElementById("cards-grid").innerHTML =
      '<div class="empty-state">Failed to load patients. Please try again.</div>';
  });
*/

function renderCards(patients) {
  var grid = document.getElementById("cards-grid");
  var count = document.getElementById("patient-count");

  count.textContent = patients.length + " patients assigned to you";

  if (patients.length === 0) {
    grid.innerHTML = '<div class="empty-state">No patients found.</div>';
    return;
  }

  grid.innerHTML = "";

  patients.forEach(function(patient, index) {

    var color = avatarColors[index % avatarColors.length];

    var card = document.createElement("div");
    card.className = "patient-card";

    card.innerHTML =
      '<div class="card-top">' +
        '<div class="avatar ' + color + '">' + patient.initials + '</div>' +
        '<div>' +
          '<div class="patient-name">' + patient.name + '</div>' +
          '<div class="patient-age">Age ' + patient.age + '</div>' +
        '</div>' +
      '</div>' +
      '<div class="card-stats">' +
        '<div class="stat-box">' +
          '<div class="stat-num">' + patient.sessions + '</div>' +
          '<div class="stat-label">Sessions</div>' +
        '</div>' +
        '<div class="stat-box">' +
          '<div class="stat-num">' + patient.reports.length + '</div>' +
          '<div class="stat-label">Reports</div>' +
        '</div>' +
      '</div>' +
      '<div class="card-footer">' +
        '<button class="btn-reports" onclick="openModal(' + patient.id + ')">View Reports</button>' +
      '</div>';

    grid.appendChild(card);
  });
}


function filterCards(query) {
  var q = query.toLowerCase();
  var filtered = allPatients.filter(function(p) {
    return p.name.toLowerCase().includes(q);
  });
  renderCards(filtered);
}

function openModal(patientId) {
  var patient = allPatients.find(function(p) { return p.id === patientId; });

  document.getElementById("modal-name").textContent = patient.name;
  document.getElementById("modal-meta").textContent = "Age " + patient.age + " · " + patient.sessions + " sessions";

  var body = document.getElementById("modal-body");

  if (patient.reports.length === 0) {
    body.innerHTML = '<div class="no-reports">No reports yet for this patient.</div>';
  } else {
    body.innerHTML = patient.reports.map(function(report) {
      return (
        '<div class="report-item">' +
          '<div class="report-date">' + report.date + '</div>' +
          '<div class="report-text">' + report.text + '</div>' +
          '<span class="report-tag">' + report.tag + '</span>' +
        '</div>'
      );
    }).join("");
  }

  document.getElementById("overlay").classList.add("open");
}

function closeModal() {
  document.getElementById("overlay").classList.remove("open");
}

document.getElementById("overlay").addEventListener("click", function(e) {
  if (e.target === this) closeModal();
});