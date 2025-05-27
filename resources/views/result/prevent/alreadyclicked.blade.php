@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="fw-bold text-danger mb-4" style="font-size: 2.5rem;">
        Already Click
    </h1>

    <!-- Video Switcher -->
    <div class="mb-4 d-flex gap-2">
        <button class="btn btn-rounded" style="color: #f24822;" onclick="switchVideo('prevent')">🎯 Prevent Phishing</button>
        <button class="btn btn-outline-secondary" onclick="switchVideo('clicked')">🚨 Already Clicked?</button>
    </div>

    <!-- Video Container -->
    <div class="ratio ratio-16x9 mb-5" id="videoContainer">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/XsOWczwRVuc?si=zUVADJZGHUONnWRA"
            title="Prevent Phishing" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <!-- Tips Section -->
    <div class="row g-4">
  <div class="col-md-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm p-3">
      <div class="card-body">
        <h5 class="card-title mb-3">Act Fast After Clicking</h5>
        <ul class="list-unstyled small text-muted">
          <li class="mb-2">Disconnect from the internet immediately.</li>
          <li class="mb-2">Turn off Wi-Fi or unplug network cable.</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm p-3">
      <div class="card-body">
        <h5 class="card-title mb-3">Scan and Secure</h5>
        <ul class="list-unstyled small text-muted">
          <li class="mb-2">Run a full antivirus or anti-malware scan.</li>
          <li class="mb-2">Log out of your accounts from all devices.</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm p-3">
      <div class="card-body">
        <h5 class="card-title mb-3">Take Remedial Action</h5>
        <ul class="list-unstyled small text-muted">
          <li class="mb-2">Change passwords, starting with email and banking.</li>
          <li class="mb-2">Report to your IT/security team or bank if needed.</li>
        </ul>
      </div>
    </div>
  </div>
</div>


<script>
    function switchVideo(type) {
        const container = document.getElementById('videoContainer');
        const videos = {
            prevent: `
                <iframe width="560" height="315"
                    src="https://www.youtube.com/embed/XsOWczwRVuc?si=zUVADJZGHUONnWRA"
                    title="Prevent Phishing"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen></iframe>
            `,
            clicked: `
                <iframe width="560" height="315"
                    src="https://www.youtube.com/embed/B06nvFCyBFs?si=sMr9OI10UOoxbTrO"
                    title="Already Clicked Phishing Link"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen></iframe>
            `
        };

        container.innerHTML = videos[type];
    }
</script>
@endsection
