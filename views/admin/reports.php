<div id="admin">
    <input type="hidden" id="accessPageNumber" value="<?= isset($_GET["accessPageNumber"]) ? $_GET["accessPageNumber"] : 1 ?>"/>
    <input type="hidden" id="errorsPageNumber" value="<?= isset($_GET["errorsPageNumber"]) ? $_GET["errorsPageNumber"] : 1 ?>"/>
    <div class="wraper">
        <?php include "views/fixed/admin-sidebar.php" ?>
            <div class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="f7afacc4-17e4-875c-6b50-56b077e542ea">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
            <div class="navbar-wrapper">
                <a class="navbar-brand">Reports</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                            <h4 class="card-title ">Access Logs</h4>
                            <p class="card-category">See accesses to various pages and info about it</p>
                            </div>
                            <div class="card-body" id="access-log">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                            <h4 class="card-title ">Errors Logs</h4>
                            <p class="card-category"> Take a look at errors encoutered on your site</p>
                            </div>
                            <div class="card-body" id="errors-log">
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>