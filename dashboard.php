<?php
  session_start();
  ob_start();
  if($_SESSION['uname']=="" || $_SESSION['paswd']=="") {
    header('location:index.php');
  }
  include('connection.php');
  $userId=$_SESSION['userId'];
  echo '<input type="hidden" id="userId_main" value="'.$userId.'"/>';
  $itemId="";
  $userRole=mysql_fetch_row(mysql_query("select mapRoleId from userrolemap where mapuserId='$userId'"))[0];
  echo '<input type="hidden" id="userRole" value="'.$userRole.'"/>';
  echo '<form method="get"><input type="hidden" id="itemId_main" name="itemId_main" value="" /></form>';
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from saturn.pinsupreme.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 21 Jan 2018 03:53:56 GMT -->
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE= edge">
  <link rel='stylesheet' href='03a03bbe34da26df16eb239ba68ecc0a.css'/>
  <link rel='stylesheet' href='assets/css/main.css'/>
  <link rel='stylesheet' href='assets/js/snackbar/snackBar.css'/>
  <link rel='stylesheet' href='assets/css/jquery-ui.css'/>
  <link rel="stylesheet" href="assets/spellcheck/extensions/modalbox/modalbox.css" type="text/css" media="screen" />
  <link href="assets/favicon.ico" rel="shortcut icon"/>
  <link href="assets/apple-touch-icon.png" rel="apple-touch-icon"/>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    @javascript html5shiv respond.min
  <![endif]-->
  <title>OCR</title>
  <style>
    .selected {
      background:#f8f8f8;
    }
    #MB_windowwrapper {
          left: 29%;
    }
  </style>
</head>

<body class="glossed">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42863888-4', 'pinsupreme.com');
  ga('send', 'pageview');

</script>
<div class="all-wrapper fixed-header hide-sub-menu">
<!-- <div class="page-header">
  <div class="header-links hidden-xs">

  <div class="top-search-w pull-right">
      <input type="text" class="top-search" placeholder="Search">
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
  <a class="logo hidden-xs" href="javascript:void(0)"><i class="fa fa-rocket"></i></a>
  <h1>OCR</h1>
</div> -->
<div id="pageLoader"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
    <div class="main-content" style="padding-top: 1%;">
      <div id="snackbar">Some text some message..</div>
    <div class="row" id="main_zoom_div">
        <iframe id="zoomFrame" src="assets/pdftohtml/web/viewer.html" style="width:100%;height:129px"></iframe>
    </div>
<div class="row">
  <div class="col-md-7">
            <div class="row" style="width:112%">
              <div class="col-md-12" id="viewFrameDiv">
                  <iframe id="viewFrame" style="width:100%;height:776px"></iframe>
              </div>
            </div>
  </div>
  <div class="col-md-1" style="text-align:right">
    <div class="row" style="height:161px">
      <div class="row" style="margin-top:6px"><button style="margin-right: 15px;width:34%" onclick="window.location.assign('logout.php');" class="btn btn-danger" id="logout"><i class="fa fa-power-off" style="font-size:13px;margin-left: -3px;"></i></button></div>
      <div class="row" style="font-size: 12px;margin-right: -12px;margin-top: 12px;"><span class="label label-success"><?php if($userRole==1){echo "Level 1 User";} else if($userRole==2){echo "Level 2 User";} else if($userRole==4){echo "Quality Checker";}else if($userRole==8){echo "Query User";} ?></span></div>
    </div>
    <div class="row" style="margin-top:6px;margin-right: -10px;font-size: 16px;"><b>Page</b></div>
    <div id="zoomDiv" style="border: 1px solid #999;margin-left: 36px;width: 66px;text-align:center">
      <div class="row" style="margin-top:6px"><button class="btn btn-primary btn-lg" id="pageNext" onclick="page('next')" style="font-size: 11px;">Next</button></div>
      <div class="row" style="margin-top:6px"><button class="btn btn-primary btn-lg" id="pagePrev" onclick="page('prev')" style="font-size: 11px;">Prev</button></div>
      <div class="row" style="margin-top:6px"><button class="btn btn-primary btn-lg" id="pageFirst" onclick="page('first')" style="font-size: 11px;">First</button></div>
      <div class="row" style="margin-top:6px;margin-bottom:6px"><button class="btn btn-primary btn-lg" onclick="page('last')" id="pageLast" style="font-size: 11px;">Last</button></div>
    </div>
    <div class="row" style="margin-top:6px;margin-right: -10px;font-size: 16px;"><b>Zoom</b></div>
    <div id="zoomDiv" style="border: 1px solid #999;margin-left: 36px;width: 66px;text-align:center">
      <div class="row" style="margin-top:6px"><button class="btn btn-primary btn-lg showZoom" id="zoomTL" style="font-size: 11px;">TL</button></div>
      <div class="row" style="margin-top:6px"><button class="btn btn-primary btn-lg showZoom" id="zoomTR" style="font-size: 11px;">TR</button></div>
      <div class="row" style="margin-top:6px"><button class="btn btn-primary btn-lg showZoom" id="zoomBL" style="font-size: 11px;">BL</button></div>
      <div class="row" style="margin-top:6px"><button class="btn btn-primary btn-lg showZoom" id="zoomBR" style="font-size: 11px;">BR</button></div>
      <div class="row" style="margin-top:6px;margin-bottom:6px"><button class="btn btn-warning  btn-lg showZoom" id="zoomCancel" style="font-size: 10px;"><i class="fa fa-times-circle" style="margin-left:4px;font-size:11px"></i></button></div>
    </div>
  </div>
  <div class="col-md-4">
      <div class="row" id="progress_div" style="margin-left: 0px;">
          <div class="table-responsive">
              <table class="table table-hover" style="font-size:12px">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Item Id</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Page Range</th>
                  </tr>
                </thead>
                <tbody id="progressTable">

                </tbody>
              </table>
              </div>
      </div>
    <span class="offset_anchor" id="widget_tabs"></span>

    <ul class="nav nav-pills" id="control_bar" style="margin-top:6%;font-size:11px">
      <li class="active"><a href="#tab_title" id="titleClick" onclick="whichClick('title','title');" data-toggle="tab">Title</a></li>
      <li><a href="#tab_keywords" id="keywordClick" onclick="whichClick('authorKeywords','keywords');" data-toggle="tab">Keywords</a></li>
      <li><a href="#tab_abstract" id="abstractClick" onclick="whichClick('authorAbstract','abstract');" data-toggle="tab">Abstract</a></li>
      <li><a href="#tab_refs" id="refsClick" onclick="whichClick('surname','refs');" data-toggle="tab">Refs</a></li>
      <li><a href="#tab_funding" id="fundingClick"onclick="whichClick('fStatement','funding');" data-toggle="tab">Funding</a></li>
      <li><a href="#tab_query" id="queryClick" onclick="whichClick('itemQuery','query');" data-toggle="tab">Query</a></li>
    </ul>
    <div class="tab-content bottom-margin">
      <div class="tab-pane active" id="tab_title">
        <form id="titleForm" method="POST">
        <div class="shadowed-bottom" style="padding-left:7%">
          <div class="row" style="margin-top:15px">
              <div class="col-md-11">
                <?php
                    include('connection.php');
                    $qrr=mysql_query("select abstracttextareaA from abstract where itemId='$itemId'");
                    $rowTitle=mysql_fetch_row($qrr);
                ?>
                <textarea type="text" style="margin-left:23px;" id="title" name="title" style="height:85px;width:100%;" placeholder="Title" class="form-control input-sm pastable"></textarea>
                </div>
          </div>
          <div class="row" style="margin-top:15px">
              <div class="col-md-11">
                  <textarea type="text" id="foreignTitle" name="foreignTitle" class="form-control pastable input-sm" style="height:85px;width:100%" placeholder="Foreign Title" class="form-control input-sm "></textarea>
              </div>
            </div>
            <div class="row" style="margin-top:15px">
                <div class="col-md-8">
                    <input type="text" id="ii1"  name="ii1" disabled placeholder="Item Identifier" onchange="itemValidator(this.id);" class="form-control input-sm pastable"/>
                    <?php // $ii=explode(";",$titleRow['itemidentifier']); if($ii[0]!=="none"){ echo $ii[0];} ?>
                </div>
                <div class="col-md-4" style="margin-left: -10px;">
                    <select onchange="onItemChange(1)" class="form-control input-sm" id="ii_sel1" name="ii_sel1" style="width:78%">
                        <option value="">NONE</option>
                        <option value="DOI">DOI</option>
                        <option value="artn">ARTN</option>
                        <option value="pii">PII</option>
                        <option value="pmid">PMID</option>
                        <option value="sici">SICI</option>
                        <option value="unsp">UNSP</option>
                      </select>
                </div>
              </div>
              <div class="row" style="margin-top:10px">
                  <div class="col-md-8">
                      <input type="text" id="ii2"  name="ii2" disabled placeholder="Item Identifier" onchange="itemValidator(this.id);" class="form-control input-sm pastable "/>
                  </div>
                  <div class="col-md-4" style="margin-left: -10px;">
                      <select class="form-control input-sm" onchange="onItemChange(2)" id="ii_sel2" name="ii_sel2" style="width:78%">
                        <option value="">NONE</option>
                        <option value="DOI">DOI</option>
                        <option value="artn">ARTN</option>
                        <option value="pii">PII</option>
                        <option value="pmid">PMID</option>
                        <option value="sici">SICI</option>
                        <option value="unsp">UNSP</option>
                      </select>
                  </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-8">
                        <input type="text" id="ii3" name="ii3" disabled placeholder="Item Identifier" onchange="itemValidator(this.id);" class="form-control input-sm pastable "/>
                    </div>
                    <div class="col-md-4" style="margin-left: -10px;">
                        <select class="form-control input-sm" onchange="onItemChange(3)" id="ii_sel3" name="ii_sel3" style="width:78%">
                          <option value="">NONE</option>
                          <option value="DOI">DOI</option>
                          <option vfalue="artn">ARTN</option>
                          <option value="pii">PII</option>
                          <option value="pmid">PMID</option>
                          <option value="sici">SICI</option>
                          <option value="unsp">UNSP</option>
                        </select>
                    </div>
                  </div>
                  <div class="row" style="margin-top:10px">
                      <div class="col-md-8">
                          <input type="text" id="ii4" name="ii4" disabled placeholder="Item Identifier" onchange="itemValidator(this.id);" class="form-control input-sm  pastable"/>
                      </div>
                      <div class="col-md-4" style="margin-left: -10px;">
                          <select class="form-control input-sm" onchange="onItemChange(4)" id="ii_sel4" name="ii_sel4" style="width:78%">
                            <option value="">NONE</option>
                            <option value="DOI">DOI</option>
                            <option value="artn">ARTN</option>
                            <option value="pii">PII</option>
                            <option value="pmid">PMID</option>
                            <option value="sici">SICI</option>
                            <option value="unsp">UNSP</option>
                          </select>
                      </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-11">
                          <form class="form-inline form-period-selector">
                            <input type="text" id="iLanguage" name="iLanguage" style="width:100%" placeholder="Item Language"  class="form-control input-sm "/>
                          </form>
                        </div>
                      </div>
                      <div class="row" style="margin-top:10px">
                          <div class="col-md-11">
                              <input type="text" id="meetingAbstract" name="meetingAbstract" style="width:100%" placeholder="Meeting Absract" class="form-control input-sm "/>
                          </div>
                        </div>
                        <div class="row brClass" style="margin-top:10px">
                            <div class="col-md-11">
                                <input type="text" id="brLanguage"  name="brLanguage" style="width:100%" placeholder="BR Language" class="form-control input-sm "/>
                            </div>
                          </div>
                          <div class="row brClass" style="margin-top:10px">
                              <div class="col-md-5">
                                  <input type="text" id="brDate" name="brDate" style="width:99%" placeholder="BR Date" class="form-control input-sm "/>
                              </div>
                              <div class="col-md-6">
                                <input type="text" id="url" name="url" style="width:100%" placeholder="URL" class="form-control input-sm "/>
                              </div>
                          </div>


        </div>
        </form>
      </div>
      <div class="tab-pane" id="tab_keywords" style="padding-top: 4%;padding-bottom: 4%;">
      <form id="keywordsForm" method="POST">
            <div class="row">
                <div class="col-md-11">
                    <textarea type="text" id="authorKeywords" name="authorKeywords" style="margin-left: 16px;height:485px;width: 377px;" placeholder="Author Keywords" class="form-control input-sm pastable"></textarea>
                </div>
            </div>

      </div>
      <div class="tab-pane" id="tab_abstract"  style="padding-top: 4%;padding-bottom: 4%;">
      <?php
          include('connection.php');
          $qrr=mysql_query("select abstracttextareaA from abstract where itemId='$itemId'");
          $row3=mysql_fetch_row($qrr);
      ?>
          <div class="row">
              <div class="col-lg-6 col-md-8 col-sm-6">
                  <textarea type="text" id="authorAbstract" name="authorAbstract" style="margin-left: 16px;height:485px;width: 377px;text-align:justify" placeholder="Abstract" class="form-control input-sm pastable"><?php if($row3[0]!=="none") {echo $row3[0];} ?></textarea>
              </div>
          </div>

          </form>
      </div>
      <div class="tab-pane" id="tab_refs" style="padding-top: 4%;padding-bottom: 4%;">
        <form id="refsForm" method="post">
            <div class="row">
                <div class="col-md-8" style="padding-left: 7%;">
                    <button class="btn btn-primary btn-sm" type="button" onclick="refNext()">Next</button>
                    <button class="btn btn-primary btn-sm" type="button" onclick="refPrev()">Prev</button>
                    <button class="btn btn-danger btn-sm" type="button" onclick="refDelete()">Delete</button>
                    <button class="btn btn-primary btn-sm" type="button" onclick="refGoto()">Go to</button>
                </div>
                <div class="col-md-4" style="padding-top:1.5%">
                  <input type="hidden" id="refItemId" name="refItemId"/>
                <a href="javascript:void(0)">(<span id="noOfRefs"></span> record found)</a>
                </div>
            </div>
            <div class="row" style="margin-top:5%">
                <div class="col-md-8">
                    <input type="text" id="surname" maxlength="15" name="surname" style="margin-left:23px;width:100%" placeholder="Surname" class="form-control input-sm pastable"/>
                </div>
                <div class="col-md-4">
                    <input type="checkbox" id="exptFCR" name="exptFCR" value="exptFCR"/>ExptFCR
                    <input type="checkbox" id="re" disabled name="re" value="re"/>RE
                </div>
            </div>
            <div class="row"  style="margin-top:2%">
                <div class="col-md-4">
                      <input type="text" id="volume" onkeypress="acceptOnlyNumber(event)" name="volume" style="margin-left:23px;width:100%" min="0" placeholder="Volume" class="form-control input-sm pastable"/>
                </div>
                <div class="col-md-4">
                      <input type="text" id="page" name="page" style="margin-left:23px;width:100%" placeholder="Page" class="form-control input-sm pastable"/>
                </div>
                <div class="col-md-4">
                <input type="text" onkeypress="acceptOnlyNumber(event)" id="year" name="year" style="margin-left:23px;width:60%" min="0" placeholder="Year" class="form-control input-sm pastable"/>
                </div>
            </div>
            <div class="row"  style="margin-top:2%">
                <div class="col-md-11">
                        <textarea type="text" id="fullTitle" name="fullTitle" style="margin-left:23px;height:100px;width:97%" placeholder="Full Title" class="form-control input-sm pastable"></textarea>
                </div>
            </div>
            <div class="row"  style="margin-top:2%">
                <div class="col-md-11">
                      <input type="text" maxlength="20"  id="dcpt" name="dcpt" style="margin-left:23px;width:97%" placeholder="DCPT" class="form-control input-sm pastable"/>
                </div>
            </div>
            <div class="row"  style="margin-top:2%">
                <div class="col-md-7">
                      <input type="text" id="artID1" name="artID1" disabled  onchange="artValidator(this.id);" style="margin-left:23px;width:100%" placeholder="Art ID" class="artid form-control input-sm pastable"/>
                </div>
                <div class="col-md-3">
                <select class="form-control input-sm artSelect" style="width:100%" id="art_sel1" onchange="artValidator('artID');">
                          <option>None</option>
                          <option>DOI</option>
                          <option>ARTN</option>
                          <option>PII</option>
                          <option>PMID</option>
                          <option>SICI</option>
                          <option>UNSP</option>
                          <option>NONE</option>
                        </select>
                </div>
                <div class="col-md-2">
                  <button id="addArt" type="button" class="btn btn-primary btn-sm">Add</button>
                </div>
                <div id="appendArt"></div>
            </div>
        </form>
      </div>
      <div class="tab-pane" id="tab_funding" style="padding-top: 4%;padding-bottom: 4%;">
      <form id="fundingForm" method="POST">
      <div class="row">
          <div class="col-md-8" style="padding-left: 7%;">
          <button class="btn btn-primary btn-sm" type="button" onclick="fundingNext()">Next</button>
          <button class="btn btn-primary btn-sm" type="button" onclick="fundingPrev()">Prev</button>
          <button class="btn btn-danger btn-sm" type="button" onclick="fundingDelete()">Delete</button>
          <button class="btn btn-primary btn-sm" type="button" onclick="fundingGoto()">Go to</button>
      </div>
      <div class="col-md-4" style="padding-top:1.5%">
        <input type="hidden" id="fundingId" name="fundingId"/>
      <a href="javascript:void(0)">(<span id="noOfFunds"></span> record found)</a>
      </div>
          </div>
          <div class="row" style="margin-top:5%">
              <div class="col-md-11">
                  <textarea type="text" id="fStatement" name="fStatement" style="margin-left:23px;height:150px;width:100%;text-align:justify" placeholder="Funding Statement" class="form-control input-sm pastable"></textarea>
              </div>
          </div>
          <div class="row" style="margin-top:2%">
              <div class="col-md-11">
                  <textarea type="text" id="fOrganization" name="fOrganization" style="margin-left:23px;height:100px;width:100%" placeholder="Funding Organization" class="form-control input-sm"></textarea>
              </div>
          </div>
          <div class="row" style="margin-top:2%">
              <div class="col-md-11">
                  <textarea type="text" id="grantNumber"  name="grantNumber" style="margin-left:23px;height:100px;width:100%" placeholder="Grant Number" class="form-control input-sm"></textarea>
              </div>
          </div>
          </form>
    </div>
    <div class="tab-pane" id="tab_query"  style="padding-top: 4%;padding-bottom: 4%;">
        <div class="row">
            <div class="col-md-12">
              <form id="queryForm" method="post" class="form-inline form-period-selector">
                <textarea type="text" id="itemQuery" name="itemQuery" style="margin-left: 16px;height:250px;width: 377px;" placeholder="Item Query" class="form-control input-sm "></textarea>
                <div class="row" style="padding-left: 8%;padding-right: 8%;padding-top: 2%;">
                    <!-- <button type="submit" style="width:100%" class="btn btn-success btn-sm">Submit</button> -->
                </div>
              </form>

            </div>
        </div>
  </div>
    </div>
  </div>
</div>
</div>

</div>

<!-- Modals -->

<div class="modal fade" id="spellChecker" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle1Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:700px">
      <form id="createTeamForm" method="POST">
      <div class="widget widget-blue">
        <div class="widget-title">
          <h3><i class="fa fa-search-plus"></i> Spell Checker for <span class="currentSpell"></span></h3>
        </div>
        <div class="widget-content">
          <div class="modal-body">
            <textarea id="spellCheckerInput" style="width:100%;height:300px"></textarea>
          </div>
          <div class="modal-footer">
              <button class="btn btn-primary" type="button" id="spellok"><i class="fa fa-check-circle"></i> Done</button>
              <button class="btn btn-danger" type="button" data-dismiss="modal" onclick="eval(tinymce.get('spellCheckerInput').setContent(''));"><i class="fa fa-times-circle"></i> Cancel</button>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- goto Ref modal -->
<div class="modal fade" id="gotoref" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle1Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:700px">
      <div class="widget widget-blue">
        <div class="widget-title">
          <h3> References</h3>
        </div>
        <div class="widget-content">
          <div class="modal-body">
            <table class="table table-hover">
              <thead>
                  <th>Reference #</th>
                  <th>Surname</th>
                  <th>Volume</th>
                  <th>Page</th>
                  <th>Year</th>
                  <th>Title</th>
                  <th>DCPT</th>
              </thead>
              <tbody id="refsTable">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- goto Funding modal -->
<div class="modal fade" id="gotofunding" role="dialog" aria-labelledby="modalFormStyle1Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:700px">
      <div class="widget widget-blue">
        <div class="widget-title">
          <h3> Funding</h3>
        </div>
        <div class="widget-content">
          <div class="modal-body">
            <table class="table table-hover">
              <thead>
                  <th>Funding #</th>
                  <th>Funding Statement</th>
                  <th>Funding Organization</th>
                  <th>Grant Number</th>
              </thead>
              <tbody id="fundingTable">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/tinymce/tinymce.min.js"></script>
<script type='text/javascript' src='assets/spellcheck/include.js' ></script>
<script type='text/javascript'  src='assets/spellcheck/extensions/modalbox/modalbox.combined.js' ></script>
<script src='assets/js/main.js'></script>
<script src="assets/js/dashboard.js"></script>
<script src='ad67372f4b8b70896e8a596720082ac6.js'></script>
<script src='6ede73fb6e204f0d1ba850a2db67eb65.js'></script>
<script src='assets/js/snackbar/snackBar.js'></script>
