<div id="admin">
  <input type="hidden" id="pageNumber" value="<?= isset($_GET["pageNumber"]) ? $_GET["pageNumber"] : 1 ?>"/>
    <div class="wraper">
        <?php include "views/fixed/admin-sidebar.php" ?>
        <div class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="f7afacc4-17e4-875c-6b50-56b077e542ea">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand">Dashboard</a>
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
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row" id="dashboard-info">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-users"></i>
                  </div>
                  <p class="card-category">Logins Today</p>
                  <h3 class="card-title" id="logins">
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-user-plus"></i>
                  </div>
                  <p class="card-category">Total Accounts</p>
                  <h3 class="card-title" id="accounts"></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-eye"></i>    
                  </div>
                  <p class="card-category">Most Popular Page</p>
                  <h3 class="card-title" id="most-popular-page-views-count"></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <a href="#" id="most-popular-page-name"></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                  <i class="fas fa-box"></i>
                  </div>
                  <p class="card-category">Orders</p>
                  <h3 class="card-title" id="orders"></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Pages Statistic</h4>
                  <p class="card-category"> Take a look at statistic for every page on site</p>
                </div>
                <div class="card-body" id="page-statistic">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: -4px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 4px; right: 0px; height: 880px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 2px; height: 597px;"></div></div></div> -->
    </div>
</div>