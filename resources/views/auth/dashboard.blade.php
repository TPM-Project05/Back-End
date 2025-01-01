<!-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    <!-- Nama Tim dan Data Leader -->
    <h2>Nama Tim: {{ $team->name }}</h2>
    <h3>Leader: {{ $team->leader->name }}</h3>

    <!-- View CV dan ID Card -->
    <a href="{{ asset('storage/' . $team->cv_path) }}" target="_blank">View CV</a>
    <a href="{{ asset('storage/' . $team->id_card_path) }}" target="_blank">View ID Card</a>

    <!-- Timeline -->
    <h3>Timeline</h3>
    <ul>
        @foreach ($timelines as $timeline)
            <li>{{ $timeline->event_name }} - {{ $timeline->event_date }}
                @if ($timeline->link)
                    (<a href="{{ $timeline->link }}" target="_blank">Link</a>)
                @endif
            </li>
        @endforeach
    </ul>

    <!-- Contact Person -->
    <p>Contact Person: {{ $contactPerson }}</p>

    <!-- Logout -->
    <button id="logoutBtn" class="btn btn-danger">Logout</button>
</div>

<!-- Popup Logout -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('logoutBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin ingin logout?',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection -->
