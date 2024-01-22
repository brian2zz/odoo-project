<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Fastprint</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login Admin</p>

      <form action="<?=base_url('')?>" method="post">
        <div class="form-group mb-3">
          <div class="input-group">
            <input type="text" class="form-control" name="username" value="<?= set_value('username')?>" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <?= form_error('username','<small class="text-danger mb-3">','</small>')?>
        </div>
        <div class="form-group mb-3">
          <div class="input-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <?= form_error('password','<small class="text-danger mb-3">','</small>')?>
        </div>
        <div class="row mb-2 d-flex justify-content-end ">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
