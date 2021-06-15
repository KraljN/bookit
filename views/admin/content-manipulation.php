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
          <button class="navbar-toggler mr-4" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
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
                      <ul class="nav nav-tabs" >
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
                    <div class="tab-pane active" id="admin-menu"></div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs">
                        <li class="nav-item d-flex align-items-center">
                          <div class="nav-link active mr-3">
                          <i class="fas fa-list mr-2"></i> Genres
                            <div class="ripple-container"></div>
                          </div>
                        </li>
                        <li class="nav-item ml-sm-auto mx-auto mt-2 mt-sm-0 mr-sm-5">
                            <form class="navbar-form">
                              <span class="bmd-form-group"><div class="input-group no-border d-flex align-items-center">
                                <input type="text" class="form-control mr-sm-2 text-white" id="genre-name" placeholder="Genre Name">
                                <button type="submit" id="add-genre" class="btn btn-white btn-round btn-just-icon mb-2">
                                  <i class="fas fa-plus"></i>
                                  <div class="ripple-container"></div>
                                </button>
                              </div></span>
                            </form>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <p class="text-danger font-weight-bold errorInfo text-center mt-3 mb-0" id="errorGenre">Genre with that name already exist</p>
                <p class="text-success font-weight-bold successInfo text-center mt-3 mb-0" id="successGenre">Genres successfully updated</p>
                <div class="card-body">
                  <?php if(isset($_SESSION["greskeGenre"])): ?>
                      <ul class="text-center mt-3 list-unstyled">
                          <?php foreach($_SESSION["greskeGenre"] as $greska): ?>
                              <li class="text-danger"><?= $greska ?></li>
                          <?php endforeach; ?>
                      </ul>
                    <?php
                    endif;
                    unset($_SESSION["greskeGenre"]);
                    ?>
                  <p class="text-danger wrong d-none text-center mt-3 mb-0">Genre Name Must be in valid format (Sci Fi)</p>
                  <div class="tab-content">
                    <div class="tab-pane active" id="admin-genres"></div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs">
                        <li class="nav-item d-flex align-items-center">
                          <div class="nav-link active mr-3">
                          <i class="fas fa-book mr-2"></i> Publishers
                            <div class="ripple-container"></div>
                          </div>
                        </li>
                        <li class="nav-item ml-sm-auto mx-auto mt-2 mt-sm-0 mr-sm-5">
                            <form class="navbar-form">
                              <span class="bmd-form-group"><div class="input-group no-border d-flex align-items-center">
                                <input type="text" class="form-control mr-sm-2 text-white" id="publisher-name" placeholder="Pubisher Name">
                                <button type="submit" id="add-publisher" class="btn btn-white btn-round btn-just-icon mb-2">
                                  <i class="fas fa-plus"></i>
                                  <div class="ripple-container"></div>
                                </button>
                              </div></span>
                            </form>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <p class="text-danger font-weight-bold errorInfo text-center mt-3 mb-0" id="errorPublisher">Publisher with that name already exist</p>
                <p class="text-success font-weight-bold successInfo text-center mt-3 mb-0" id="successPublisher">Publishers successfully updated</p>
                <div class="card-body">
                  <?php if(isset($_SESSION["greskePublisher"])): ?>
                      <ul class="text-center mt-3 list-unstyled">
                          <?php foreach($_SESSION["greskePublisher"] as $greska): ?>
                              <li class="text-danger"><?= $greska ?></li>
                          <?php endforeach; ?>
                      </ul>
                    <?php
                    endif;
                    unset($_SESSION["greskePublisher"]);
                    ?>
                  <p class="text-danger wrong d-none text-center mt-3 mb-0">Publisher Name Must be in valid format (St. Martin's Press)</p>
                  <div class="tab-content">
                    <div class="tab-pane active" id="admin-publishers"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs">
                        <li class="nav-item d-flex align-items-center">
                          <div class="nav-link active mr-3">
                          <i class="fas fa-pen-fancy mr-2"></i> Authors
                            <div class="ripple-container"></div>
                          </div>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn active adminAdd" href="index.php?page=author-form">
                            <i class="fas fa-plus mr-2"></i> Add Author
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="admin-authors"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs">
                        <li class="nav-item d-flex align-items-center">
                          <div class="nav-link active mr-3">
                          <i class="fas fa-user mr-2"></i> Users
                            <div class="ripple-container"></div>
                          </div>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn active adminAdd" href="index.php?page=user-form">
                            <i class="fas fa-plus mr-2"></i> Add User
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="admin-users"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs">
                        <li class="nav-item d-flex align-items-center">
                          <div class="nav-link active mr-3">
                          <i class="fas fa-book-open mr-2"></i></i> Books
                            <div class="ripple-container"></div>
                          </div>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn active adminAdd" href="index.php?page=book-form">
                            <i class="fas fa-plus mr-2"></i> Add Book
                          </a>
                        </li>
                        <li class="nav-item mt-2 mt-sm-0 mx-auto mr-sm-0 ml-sm-auto">
                          <a class="nav-link btn active adminAdd" href="models/excel/export-books-excel.php">
                          <i class="fas fa-file-excel mr-2"></i>Download Catalog
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="admin-books"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>