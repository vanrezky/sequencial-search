<div class="kenne-login-register_area">
    <div class="container">
        <div class="row">
            <div id="loginRegisterForm" class="col-sm-12 col-md-12 col-xs-12 col-lg-5 mx-auto">
                <?= $this->session->flashdata('message');?>
                <form id="loginForm" action="<?= base_url('member/masuk')?>">
                    <div class="login-form">
                        <h4 class="login-title">Login Sekarang</h4>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <label>Email*</label>
                                <input type="email" placeholder="Email" name="email">
                            </div>
                            <div class="col-12 mb--20">
                                <label>Password</label>
                                <input type="password" placeholder="Password" name="password">
                            </div>
                            <div class="col-md-12">
                                <div class="forgotton-password_info">
                                    <a href="#"> Lupa password?</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="kenne-login_btn">Login</button>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="kenne-login_btn daftar-baru">daftar sekarang</button>
                            </div>
                            
                        </div>
                    </div>
                </form>
                <form id="regisForm" action="<?= base_url('member/daftar')?>" hidden>
                    <div class="login-form">
                        <h4 class="login-title">Daftar Akun Baru</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb--20">
                                <label>Nama Lengkap</label>
                                <input type="text" placeholder="Nama Lengkap" name="nama">
                            </div>
                            <div class="col-md-12">
                                <label>Email*</label>
                                <input type="email" placeholder="Email" name="email">
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="password" placeholder="Password" name="pass1">
                            </div>
                            <div class="col-md-6">
                                <label>Konfirmasi Password</label>
                                <input type="password" placeholder="Konfirmasi Password" name="pass2">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="kenne-register_btn">Daftar</button>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="kenne-register_btn form-login">punya akun? login sekarang</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        const loginForm = $('#loginForm');
        const regisForm = $('#regisForm');
        const loginRegisterForm = $('#loginRegisterForm');
        $('.daftar-baru').click(function(x) {
            x.preventDefault();
            loginForm.attr('hidden', true);
            regisForm.attr('hidden', false);
            loginRegisterForm.find('input:text').val(''); 
        });

        $('.form-login').click(function(x) {
            x.preventDefault();
            loginForm.attr('hidden', false);
            regisForm.attr('hidden', true);
            loginRegisterForm.find('input:text').val('');
        });

        regisForm.submit(function (e) {
            e.preventDefault();
				SimpanMaster(this,  $(this).attr('action'), function(success) {
                }, function(error) {});
            return false;
        });

        loginForm.submit(function (e) {
            e.preventDefault();
                SimpanMaster(this,  $(this).attr('action'), function(success) {
                }, function(error) {});
            return false;
        });

    })
</script>