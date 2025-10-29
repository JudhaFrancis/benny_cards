

<?php $__env->startSection('title','BENNY CARDS || Login Page'); ?>

<?php $__env->startSection('main-content'); ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="<?php echo e(route('home')); ?>">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Login -->
<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div id="login-form-section" class="login-form">
                    <h2>Login</h2>
                    <p>Please register in order to checkout more quickly</p>
                    <!-- Form -->
                    <form class="form" method="post" action="<?php echo e(route('login.submit')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Email<span>*</span></label>
                                    <input type="email" name="email" placeholder="" required="required"
                                        value="<?php echo e(old('email')); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Password<span>*</span></label>
                                    <input type="password" name="password" placeholder="" required="required"
                                        value="<?php echo e(old('password')); ?>">
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Login</button>
                                    <a href="<?php echo e(route('register.form')); ?>" class="btn">Register</a>
                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="2"><input name="news" id="2"
                                            type="checkbox">Remember me</label>
                                </div>
                                <a href="javascript:void(0)" id="show-forgot-password" class="lost-pass">
                                    Lost your password?
                                </a>
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
                </div>

                <!-- Forgot Password Form -->
                <div id="forgot-form-section" class="login-form" style="display: none;">
                    <h2>Reset Password</h2>
                    <p>Enter your registered email address to continue.</p>

                    <!--  Email check -->
                    <form id="email-check-form">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label>Email Address<span>*</span></label>
                            <input type="email" id="reset-email" name="email" placeholder="Enter your registered email"
                                required>
                            <span id="email-error" class="text-danger mt-2 d-block"></span>
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center mt-4">
                            <a href="javascript:void(0)" id="back-to-login" class="btn btn-outline-secondary">Back to
                                Login</a>
                            <button type="button" id="check-email-btn" class="btn">Continue</button>
                        </div>
                    </form>


                    <!-- New Password fields -->
                    <form id="new-password-form" style="display: none;" method="POST"
                        action="<?php echo e(route('password.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="hidden-email" name="email">

                        <div class="form-group mt-3">
                            <label>New Password<span>*</span></label>
                            <input type="password" name="password" placeholder="Enter new password" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password<span>*</span></label>
                            <input type="password" name="password_confirmation" placeholder="Confirm new password"
                                required>
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn">Update Password</button>
                            <a href="javascript:void(0)" id="cancel-reset" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<!--/ End Login -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style>
#forgot-form-section {
    padding: 30px;

}

#forgot-form-section .form-group label {
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
}

#forgot-form-section input[type="email"],
#forgot-form-section input[type="password"] {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 15px;
    transition: border-color 0.3s;
}

#forgot-form-section input:focus {
    border-color: #6c63ff;
    outline: none;
}

#forgot-form-section .btn {
    min-width: 130px;
    text-align: center;
    padding: 10px 20px;
    border-radius: 6px;
}

#forgot-form-section .form-group.d-flex {
    margin-top: 25px;
    justify-content: center;
    gap: 15px;
}

.shop.login .form .btn {
    margin-right: 0;
}

.btn-facebook {
    background: #39579A;
}

.btn-facebook:hover {
    background: #073088 !important;
}

.btn-github {
    background: #444444;
    color: white;
}

.btn-github:hover {
    background: black !important;
}

.btn-google {
    background: #ea4335;
    color: white;
}

.btn-google:hover {
    background: rgb(243, 26, 26) !important;
}

.lost-pass {
    color: #6c63ff;
    text-decoration: none;
    font-weight: 600;
}

.lost-pass:hover {
    text-decoration: underline;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Toggle between login and forgot form
document.getElementById('show-forgot-password').addEventListener('click', function() {
    document.getElementById('login-form-section').style.display = 'none';
    document.getElementById('forgot-form-section').style.display = 'block';
});
document.getElementById('back-to-login').addEventListener('click', function() {
    document.getElementById('forgot-form-section').style.display = 'none';
    document.getElementById('login-form-section').style.display = 'block';
});
document.getElementById('cancel-reset').addEventListener('click', function() {
    document.getElementById('new-password-form').style.display = 'none';
    document.getElementById('email-check-form').style.display = 'block';
});

// Step 1: Check email exists
document.getElementById('check-email-btn').addEventListener('click', function() {
    const email = document.getElementById('reset-email').value;
    const error = document.getElementById('email-error');
    error.textContent = '';

    fetch('/check-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: JSON.stringify({
                email
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                document.getElementById('hidden-email').value = email;
                document.getElementById('email-check-form').style.display = 'none';
                document.getElementById('new-password-form').style.display = 'block';
            } else {
                error.textContent = 'This email is not registered';
            }
        })
        .catch(() => {
            error.textContent = 'Something went wrong. Try again';
        });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/frontend/pages/login.blade.php ENDPATH**/ ?>