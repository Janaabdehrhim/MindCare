<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MindCare</title>

    <link rel="stylesheet" href="{{ asset('assets/CSS/plugins/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/CSS/plugins/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/CSS/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/CSS/session.css') }}" />
</head>

<body>

<<<<<<< HEAD
@include('shared.nav')

<header class="hdr">
    <div class="d-flex align-items-center gap-3">
        <div class="hdr-info">
            <h2>
                Session with
                <span id="patient-name">
                {{ $session->patient?->first_name }}
                {{ $session->patient?->last_name }}
                </span>
            </h2>
=======
    <header class="hdr">
        <div class="d-flex align-items-center gap-3">
            <div class="hdr-info">
                <h2>Session with <span id="patient-name">Sara Ahmed</span></h2>
            </div>
>>>>>>> 269aae40ea49df44f6993ad35589eb8a16963514
        </div>
    </div>

    <div class="hdr-right">
        <span class="badge-live"><span class="dot-live"></span>{{ ucfirst($session->status) }}</span>
        <span class="hdr-timer" id="dur">00:00</span>
    </div>
</header>

<div class="main">

    <div class="video-section">

        <div class="video-grid">

        
            <div class="vid-card">
                <div class="vid-box speaking" id="vid-self">

                    <div class="vid-avatar av-green" id="av-self">
                        {{ strtoupper(substr(auth()->guard('therapist')->user()->first_name,0,1)) }}
                        {{ strtoupper(substr(auth()->guard('therapist')->user()->last_name,0,1)) }}
                    </div>

                    <div class="wave-wrap">
                        <div class="wb"></div>
                        <div class="wb"></div>
                        <div class="wb"></div>
                        <div class="wb"></div>
                        <div class="wb"></div>
                    </div>

                    <div class="vid-bar">
                        <span class="vid-bar-name">
                            Dr. {{ auth()->guard('therapist')->user()->first_name }}
                            {{ auth()->guard('therapist')->user()->last_name }}
                            (You)
                        </span>
                        <span class="mute-pill">Muted</span>
                    </div>
                </div>
                <span class="vid-name">You</span>
            </div>


            <div class="vid-card">
                <div class="vid-box" id="vid-patient">

                    <div class="vid-avatar av-warm">

                        {{ strtoupper(substr($session->patient?->first_name,0,1)) }}
                        {{ strtoupper(substr($session->patient?->last_name,0,1)) }}

                    </div>

                    <div class="wave-wrap">
                        <div class="wb"></div>
                        <div class="wb"></div>
                        <div class="wb"></div>
                        <div class="wb"></div>
                        <div class="wb"></div>
                    </div>

                    <div class="vid-bar">
                        <span class="vid-bar-name">{{ $session->patient?->first_name }}
                            {{ $session->patient?->last_name }}</span>
                    </div>
                </div>
                <span class="vid-name">{{ $session->patient?->first_name }}</span>
            </div>

        </div>

        
        <div class="controls">

            <button class="ctrl" id="btn-mic" title="Mute" onclick="toggleMic()">Mic</button>
            <button class="ctrl" title="Session Notes" onclick="switchTab('notes')">Notes</button>
            <button class="ctrl" title="Chat" onclick="switchTab('chat')">Chat</button>
            <button class="ctrl end-call" title="End session">

            <form method="POST" action="{{ route('therapist.sessions.status', $session) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="completed">
                <button type="submit" class="ctrl end-call">End Session</button>
            </form>

        </div>

    </div>

    
    <div class="side">

        <div class="tabs">
            <button class="tab-btn on" id="tab-notes" onclick="switchTab('notes')">Session Notes</button>
            <button class="tab-btn" id="tab-chat" onclick="switchTab('chat')">Chat</button>
        </div>

        <div class="panel on" id="panel-notes">

            <div class="notes-body">

                <p style="font-size:11px;color:var(--muted);">Clinical notes — private to you</p>

                <form method="POST" action="{{ route('therapist.sessions.notes', $session) }}">
                    @csrf
                    @method('PATCH')
                    <textarea class="form-control mb-3" name="notes" rows="8" placeholder="Write session observations...">{{ $session->notes }}</textarea>
                    <button class="save-btn" type="submit">Save Notes</button>
                </form>

            </div>
        </div>

        
        <div class="panel" id="panel-chat">

            <div class="chat-body" id="chat-msgs">

                <div class="msg">
                    <span class="msg-who">{{ $session->patient?->first_name }}</span>
                    <div class="bubble">Welcome to the session 👋</div>
                </div>

            </div>

            <div class="chat-footer">

                <input type="text" id="chat-in" placeholder="Send message..." />

                <button class="send-btn"
                        onclick="sendMsg()">

                    ↑

                </button>

            </div>
        </div>

    </div>

</div>

<div class="loadingPage">
    <div class="loader"></div>
</div>

<script src="{{ asset('assets/JS/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/JS/plugins/jQuery.js') }}"></script>
<script src="{{ asset('assets/JS/global.js') }}"></script>

</body>
</html>