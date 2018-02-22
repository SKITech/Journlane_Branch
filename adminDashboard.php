<?php
  session_start();
  ob_start();
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from saturn.pinsupreme.com/forms.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 21 Jan 2018 03:54:34 GMT -->
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel='stylesheet' href='03a03bbe34da26df16eb239ba68ecc0a.css'>
  <link rel='stylesheet' href='assets/css/jquery-ui.css'>
  <link href="assets/favicon.ico" rel="shortcut icon">
  <link href="assets/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    @javascript html5shiv respond.min
  <![endif]-->

  <title>Admin Dashboard</title>
<style>
  .modal-backdrop {
    display:none;
  }
</style>
</head>

<body class="glossed">
<div class="all-wrapper fixed-header left-menu">
  <div class="page-header">
  <div class="header-links hidden-xs">
    <div class="top-search-w pull-right">
      <input type="text" class="top-search" placeholder="Search"/>
    </div>

    <div class="dropdown">
      <a href="javascript:void(0)" class="header-link clearfix" data-toggle="dropdown">
        <div class="avatar">
          <img src="" alt="">
        </div>
        <div class="user-name-w">
          <?php echo ucwords($_SESSION['uname']); ?> <i class="fa fa-caret-down"></i>
        </div>
      </a>
      <ul class="dropdown-menu dropdown-inbar">
        <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
      </ul>
    </div>
  </div>
  <a class="logo hidden-xs" href="index-2.html"><i class="fa fa-rocket"></i></a>
  <a class="menu-toggler" href="#"><i class="fa fa-bars"></i></a>
  <h1>ADMIN DASHBOARD</h1>
</div>
  <div class="side">
  <div class="sidebar-wrapper">
  <ul>
    <li>
      <a href="adminDashboard.php" data-toggle="tooltip" data-placement="right" title="" data-original-title="Dashboard">
        <i class="fa fa-home"></i>
      </a>
    </li>
  </ul>
</div>
  <div class="sub-sidebar-wrapper">
  <ul>
    <li class='current'><a class='current' href="adminDashboard.php"> Users &amp; Teams</a></li>
    <li><a class='current' href="reports.php"> Reports</a></li>
  </ul>
</div>
  </div>
  <div class="main-content">
    <div class="row">
      <div class="col-md-7">
        <div class="widget widget-green">
          <div class="widget-title">
          <div class="widget-controls">
                <a id="newUser" href="javascript:void(0)" data-toggle="modal" title="Add New User" style="color:white"><i class="fa fa-plus"></i> Add User</a>
          </div>
            <h3><i class="fa fa-user"></i> Users</h3>
          </div>
          <div class="widget-content">
          <table class="table table-bordered table-hover datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Level</th>
                <th>Team</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                include('connection.php');
                $qry=mysql_query("select * from users");
                $i=1;
                while($row1=mysql_fetch_assoc($qry)) {
                  $id=$row1['id'];
                  echo "
                    <tr>
                        <td>".$i."</td>
                        <td>".$row1['uname']."</td>
                        <td>".$row1['paswd']."</td>
                        <td>".$row1['userlevel']."</td>
                        <td>".$row1['team']."</td>
                        <td>
                            <a class='btn btn-primary btn-xs' onclick=editUser('$id')><i class='fa fa-edit'></i></a>
                            <a class='btn btn-danger btn-xs' onclick=deleteUser('$id')>X</a>
                        </td>
                    </tr>
                  ";
                  $i++;
                }
              ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="widget widget-blue">
          <div class="widget-title">
          <div class="widget-controls">
                <a href="javascript:void(0)" id="newTeam" data-toggle="modal" title="Create new team" style="color:white"><i class="fa fa-plus"></i>Add Team</a>
          </div>
            <h3><i class="fa fa-users"></i> Teams</h3>
          </div>
          <div class="widget-content">
          <table class="table table-bordered table-hover datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Team Name</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  include('connection.php');
                  $qry1=mysql_query("select * from teams");
                  $i=1;
                  while($row2=mysql_fetch_assoc($qry1)) {
                    $team=$row2['team'];
                    $id=$row2['id'];
                    echo "
                      <tr>
                          <td>".$i."</td>
                          <td class='teamDiv".$id."'>".$row2['team']."</td>
                          <td>
                              <a class='btn btn-primary btn-xs editTeam' id='$id'><i class='fa fa-edit'></i></a>
                              <a class='btn btn-danger btn-xs deleteTeam' id='$id' >X</a>
                          </td>
                      </tr>
                    ";
                    $i++;
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      <!-- User Modal -->
      <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle1Label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form id="createUserForm" method="POST">
            <div class="widget widget-blue">
              <div class="widget-title">
                <h3><i class="fa fa-ok-circle"></i> New User</h3>
              </div>
              <div class="widget-content">
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" id="uname" name="uname" class="form-control" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input type="password" id="paswd" name="paswd" class="form-control" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <select class="form-control" id="userLevel" name="userLevel">
                      <option value="">- Select User Level -</option>
                      <option value="level1">Level 1</option>
                      <option value="level2">Level 2</option>
                      <option value="qc">QC Operator</option>
                      <option value="query">Query Operator</option>
                      <option value="admin">admin</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <select class="form-control" id="team" name="team">
                      <option value="">- Select Team -</option>
                      <option value="team1">Team 1</option>
                    </select>
                  </div>
                  <button type="submit" id="userCreateBtn" class="btn btn-primary">Create</button>
                  <button type="submit" id="userUpdateBtn" style="display:none" class="btn btn-primary">Update</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Edit Modal -->
      <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle1Label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form id="createUserForm" method="POST">
            <div class="widget widget-blue">
              <div class="widget-title">
                <h3><i class="fa fa-ok-circle"></i> New User</h3>
              </div>
              <div class="widget-content">
                <div class="modal-body">
                  <div class="form-group">
                    <input type="text" id="uname" name="uname" class="form-control" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input type="password" id="paswd" name="paswd" class="form-control" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <select class="form-control" id="userLevel" name="userLevel">
                      <option value="">- Select User Level -</option>
                      <option value="level1">Level 1</option>
                      <option value="level2">Level 2</option>
                      <option value="qc">QC Operator</option>
                      <option value="query">Query Operator</option>
                      <option value="admin">admin</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <select class="form-control" id="team" name="team">
                      <option value="">- Select Team -</option>
                      <option value="team1">Team 1</option>
                    </select>
                  </div>
                  <button type="submit" id="userCreateBtn" class="btn btn-primary">Create</button>
                  <button type="submit" id="userUpdateBtn" style="display:none" class="btn btn-primary">Update</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Team Modal -->
      <div class="modal fade" id="newTeamModal" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle1Label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form id="createTeamForm" method="POST">
            <div class="widget widget-blue">
              <div class="widget-title">
                <h3><i class="fa fa-ok-circle"></i> New Team</h3>
              </div>
              <div class="widget-content">
                <div class="modal-body">
                  <form id="createTeamForm" method="post">
                    <input type="hidden" id="teamStatusHidden" name="teamStatusHidden"/>
                    <input type="hidden" id="teamIdHidden" name="teamIdHidden"/>
                    <div class="form-group">
                      <input type="text" id="teamName" name="teamName" class="form-control" placeholder="Username">
                    </div>
                    <button type="submit" id="teamCreateBtn" class="btn btn-primary">Submit</button>
                    <button type="submit" id="teamUpdateBtn" style="display:none" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src='ad67372f4b8b70896e8a596720082ac6.js'></script>
<script src='0ecdc2a1f21af0053c8e1d78bc57a41a.js'></script>
<script src='assets/js/admin.js'></script>

</body>


<!-- Mirrored from saturn.pinsupreme.com/forms.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 21 Jan 2018 03:54:35 GMT -->
</html>
