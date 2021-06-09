<div id="admin">
  <input type="hidden" id="pageNumber" value="<?= isset($_GET["pageNumber"]) ? $_GET["pageNumber"] : 1 ?>"/>
    <div class="wraper">
        <?php include "views/fixed/admin-sidebar.php" ?>
        <div class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="f7afacc4-17e4-875c-6b50-56b077e542ea">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand">Content Manipulation</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
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
      <div class="col-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <div class="nav-link active mr-3" href="#profile">
                          <i class="fas fa-bars mr-2"></i> Menu
                            <div class="ripple-container"></div>
                          </div>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn active adminAdd" href="index.php?page=menu-item-form">
                            <i class="fas fa-plus mr-2"></i> Add Item
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="admin-menu">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        #   
                                    </th>
                                    <th>
                                        Text
                                    </th>
                                    <th>
                                        Link
                                    </th>
                                    <th>
                                        Priority
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        1
                                    </td>
                                    <td>Home</td>
                                    <td>index.php?page=home</td>
                                    <td>10</td>
                                    <td class="td-actions text-right">
                                    <button data-id="1" class="btn btn-primary btn-link btn-sm edit">
                                        <i class="material-icons">Edit</i>
                                    </button>
                                    <button data-id="1" class="btn btn-danger btn-link btn-sm delete">
                                        <i class="material-icons">Delete</i>
                                    </button>
                                    </td>
                                </tr>
                            </tbody>
                      </table>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      </div>
    </div>
</div>
</div>