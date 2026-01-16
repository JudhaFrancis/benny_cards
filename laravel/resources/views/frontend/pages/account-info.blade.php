@extends('frontend.layouts.master')

@section('main-content')
<div class="container py-5 account-page">
    <h2>Account Information</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">

            <form method="POST" action="{{ route('user.account.update') }}" enctype="multipart/form-data">
                @csrf

                <h5 class="mb-4 text-center fw-semibold">Personal Info</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name <span>*</span></label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $user->name }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span>*</span></label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $user->email }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ $user->phone }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Upload Image</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-actions text-center">
                    <button type="submit" class="btn btn-warning">
                        Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
<style>

.account-page {
   	padding: 100px 0;

}

/* heading மேல் இடம் */
.account-page h2 {
    position: relative;
    font-size: 35px;
    color: #333;
    font-weight: 400;
    line-height: 27px;
    text-transform: uppercase;
    margin-top: 120px;   /* இங்க தான் மேலே space வரும் */
    margin-bottom: 20px; /* heading மற்றும் form இடையே */
    text-align: center;
}
.account-page h5 {
    margin-top: 20px;  /* Personal Info heading மேல் space */
    font-size: 20px;
    font-weight: 600;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
    color: #333;
}

.form-group label span {
    color: red;
}

.form-control {
    height: 48px;
    padding: 12px 14px;
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #e1e1e1;
    background: #fafafa;
}

.form-control:focus {
    border-color: #ec1176;
    background: #fff;
    box-shadow: none;
}

/* File input */
input[type="file"].form-control {
    padding: 10px;
}

/* Button */
.form-actions {
    margin-top: 30px;
}

.form-actions .btn {
    padding: 10px 36px;
    border-radius: 50px;
    font-weight: 600;
}

</style>