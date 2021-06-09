<?php if(isset($_GET["id"])){
  require_once  "config/connection.php";
  $query = "SELECT * 
            FROM navigation
            WHERE navigation_id = ?";
  $navigationPrepare = $db -> prepare($query);
  $navigationPrepare -> execute([$_GET["id"]]);
  $menuItem = $navigationPrepare -> fetch();
} ?>


<div id="admin">
  <input type="hidden" id="id" value="<?php if(isset($_GET["id"])) echo($_GET["id"]) ?>" />
  <div class="wraper">
    <?php include "views/fixed/admin-sidebar.php" ?>
    <div class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="f7afacc4-17e4-875c-6b50-56b077e542ea">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
          <div class="container-fluid">
            <div class="navbar-wrapper">
              <a class="navbar-brand"></a>
            </div>
            <button class="navbar-toggler mr-4" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
              <span class="sr-only">Toggle navigation</span>
              <span class="navbar-toggler-icon icon-bar"></span>
              <span class="navbar-toggler-icon icon-bar"></span>
              <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
              <!-- <form class="navbar-form">
                <span class="bmd-form-group"><div class="input-group no-border">
                  <input type="text" value="" class="form-control" placeholder="Search...">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon">
                    <i class="material-icons">search</i>
                    <div class="ripple-container"></div>
                  </button>
                </div></span>
              </form> -->
            </div>
          </div>
        </nav>
        <div class="content px-0">
            <div class="col-12 col-sm-10 col-md-9  col-lg-8 mx-auto">
              <div class="card" id="menu-item-add-form">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Add Menu Item</h4>
                  <p class="card-category">Add one navigational component to your site</p>
                </div>
                <div class="card-body">
                  <form action="obrada.php" method="POST">
                    <div class="row m-0 mt-2">
                      <div class="col-md-6 pl-0 pr-0 pr-md-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" placeholder="Menu Tab Name" value="<?php if(isset($_GET["id"])) echo($menuItem -> text) ?>" id="name" class="form-control">
                          <span class="text-danger  wrong d-none">Name must be well formated (Home Page)</span>
                        </div>
                      </div>
                      <div class="col-md-6 pr-0 pl-0 pl-md-2">
                        <div class="form-group bmd-form-group">
                          <input type="number" min=1 id="priority" value="<?php if(isset($_GET["id"])) echo($menuItem -> priority) ?>" placeholder="Priority" class="form-control">
                          <span class="text-danger wrong d-none">Priority must be above 0</span>
                        </div>
                      </div>
                    </div>
                    <div class="row m-0 mb-5">
                        <div class="col-12 px-0">
                            <div class="form-group bmd-form-group">
                            <input type="text" id="url" value="<?php if(isset($_GET["id"])) echo($menuItem -> href) ?>" placeholder="Menu Tab URL" class="form-control">
                            <span class="text-danger  wrong d-none">Provide valid url address ([www.]pera.com)</span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary float-right mt-3" id="<?php if(isset($_GET["id"])) echo("edit-menu-submit"); else echo ("add-menu-submit") ?>" value="Add"/>
                    <div class="clearfix"></div>
                    <div class="row m-0 d-felx justify-content-center">
                      <span class="text-success text-center font-weight-bold successInfo"><?php if(isset($_GET["id"])) echo("Menu item succefuly updated"); else echo ("Menu item succefuly added") ?></span>
                      <span class="text-danger text-center font-weight-bold mb-3 errorInfo">Allready exist menu item with that url or name</span>
                    </div>
                    <?php if(isset($_SESSION["greske"])): ?>
                      <ul class="text-center mt-3 list-unstyled">
                          <?php foreach($_SESSION["greske"] as $greska): ?>
                              <li class="text-danger"><?= $greska ?></li>
                          <?php endforeach; ?>
                      </ul>
                    <?php
                    endif;
                    unset($_SESSION["greske"]);
                    ?>
                  </form>
                </div>
                </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>