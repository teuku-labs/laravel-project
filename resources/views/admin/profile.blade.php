@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;">Profil Admin</h2>
</div>
<div class="table-card" style="max-width:500px;margin:0 auto;text-align:center;">
    <div style="width:90px;height:90px;background:linear-gradient(135deg,var(--primary-green),var(--dark-green));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:2.2rem;font-weight:700;margin:0 auto 1rem;">
        {{ substr($user->username ?? 'A', 0, 1) }}
    </div>
    <h4 style="font-weight:700;margin-bottom:.25rem;">{{ $user->username }}</h4>
    <p style="color:var(--text-muted);font-size:.88rem;margin-bottom:2rem;">Administrator</p>
    @foreach([['Email',$user->email,'fas fa-envelope'],['Username',$user->username,'fas fa-user'],['Role','Admin','fas fa-shield-alt']] as [$label,$val,$icon])
    <div style="display:flex;align-items:center;padding:.85rem 0;border-bottom:1px solid #eee;gap:.85rem;text-align:left;">
        <div style="width:38px;height:38px;background:var(--light-green);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--dark-green);flex-shrink:0;"><i class="{{ $icon }}"></i></div>
        <div><div style="font-size:.78rem;color:var(--text-muted);">{{ $label }}</div><div style="font-weight:500;font-size:.9rem;">{{ $val }}</div></div>
    </div>
    @endforeach
    <div style="margin-top:1.5rem;">
        <a href="{{ route('admin.settings') }}" style="background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:white;padding:.75rem 2rem;border-radius:10px;text-decoration:none;font-weight:500;"><i class="fas fa-key"></i> Ubah Password</a>
    </div>
</div>
@endsection