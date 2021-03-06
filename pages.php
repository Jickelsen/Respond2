<?php    
    include 'app.php'; // import php files
	
	$authUser = new AuthUser(); // get auth user
	$authUser->Authenticate('All');	
	
	Utilities::SetLanguage($authUser->Language); // set language
?>
<!DOCTYPE html>
<html>

<head>
	
<title><?php print _("Pages"); ?>&mdash;<?php print $authUser->SiteName; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<!-- include css -->
<link href="<?php print FONT; ?>" rel="stylesheet" type="text/css">
<link href="<?php print BOOTSTRAP_CSS; ?>" rel="stylesheet">
<link href="<?php print FONTAWESOME_CSS; ?>" rel="stylesheet">
<link type="text/css" href="css/app.css?v=<?php print VERSION; ?>" rel="stylesheet">
<link type="text/css" href="css/messages.css?v=<?php print VERSION; ?>" rel="stylesheet">
<link type="text/css" href="css/list.css?v=<?php print VERSION; ?>" rel="stylesheet">

</head>

<body data-currpage="pages" data-timezone="<?php print $authUser->TimeZone; ?>">
	
<?php include 'modules/menu.php'; ?>

<!-- messages -->
<input id="msg-add-error" value="<?php print _("Name and Friendly URL are required"); ?>" type="hidden">
<input id="msg-adding" value="<?php print _("Adding page..."); ?>" type="hidden">
<input id="msg-added" value="<?php print _("Page added successfully"); ?>" type="hidden">
<input id="msg-removing" value="<?php print _("Removing page..."); ?>" type="hidden">
<input id="msg-removed" value="<?php print _("Page removed successfully"); ?>" type="hidden">
<input id="msg-remove-error" value="<?php print _("There was a problem removing the page"); ?>" type="hidden">
<input id="msg-all-required" value="<?php print _("All fields are required"); ?>" type="hidden">
<input id="msg-type-adding" value="<?php print _("Adding page type..."); ?>" type="hidden">
<input id="msg-type-added" value="<?php print _("Page type added successfully"); ?>" type="hidden">
<input id="msg-type-updating" value="<?php print _("Updating page type..."); ?>" type="hidden">
<input id="msg-type-updated" value="<?php print _("Page type updated successfully"); ?>" type="hidden">
<input id="msg-type-removing" value="<?php print _("Removing page type..."); ?>" type="hidden">
<input id="msg-type-removed" value="<?php print _("Page type removed successfully"); ?>" type="hidden">
<input id="msg-type-remove-error" value="<?php print _("There was a problem removing the page type"); ?>" type="hidden">
<input id="msg-unpublished" value="<?php print _("The page was un-published successfully"); ?>" type="hidden">
<input id="msg-published" value="<?php print _("The page was published successfully"); ?>" type="hidden">
<input id="msg-publish-error" value="<?php print _("There was a problem publishing/un-publishing the page"); ?>" type="hidden">

<section class="main">

    <nav>
        <a class="show-menu"><i class="fa fa-bars fa-lg"></i></a>
        
        <div class="fs-container">
    
			<div class="fs">
			
		        <ul>
		            <li class="root" data-bind="click: switchPageType, css: {'active': friendlyId()=='root'}"><a data-friendlyid="root" data-pagetypeuniqid="-1" data-types="Page" data-typep="Pages" data-layout="content" data-stylesheet="content">/</a></li>
		        	<!--ko foreach: pageTypes -->
		    		<li data-bind="css: {'active': friendlyId()==$parent.friendlyId()}"><a data-bind="text: dir, attr: {'data-friendlyid': friendlyId, 'data-pagetypeuniqid': pageTypeUniqId, 'data-types': typeS, 'data-typep': typeP, 'data-layout': layout, 'data-stylesheet': stylesheet}, click: $parent.switchPageType"></a> 
		    		<?php if($authUser->Role=='Admin'){ ?>
		    		<i data-bind="click: $parent.showRemovePageTypeDialog" class="fa fa-minus-circle fa-lg"></i>
		    		<?php } ?>
		    		</li>
		    		<!--/ko -->
		    		<?php if($authUser->Role=='Admin'){ ?>
		            <li class="add"><i class="fa fa-plus-circle fa-lg" data-bind="click: showAddPageTypeDialog"></i></li>
		             <?php } ?>
		        </ul>
	        
			</div>
			<!-- /.fs -->
        
        </div>
        <!-- /.fs-container -->
        
        <a class="primary-action" data-bind="click: showAddDialog"><i class="fa fa-plus-circle fa-lg"></i> <?php print _("Add Page"); ?></a>
    </nav>
    
    <div class="list-menu">
    	<?php include 'modules/account.php'; ?>
    	
		<div class="list-menu-actions">
    		<a title="Sort by Last Modified" class="active" data-bind="click:sortDate"><i class="fa fa-sort-amount-desc"></i></a>
			<a title="Sort by Name"><i class="fa fa-sort-alpha-asc" data-bind="click:sortName"></i></a>
			<a><i class="fa fa-cog" data-bind="click: showEditPageTypeDialog, visible: pageTypeUniqId()!=-1"></i></a>
		</div>
    </div>

    <div class="list" data-bind="foreach: pages">
    
    	<div class="listItem" data-bind="attr: { 'data-id': pageUniqId, 'data-name': name, 'data-isactive': isActive}, css: {'has-thumb': thumb()!=''}">
        
            <span class="image" data-bind="if: thumb()!=''"><img height="75" width="75" data-bind="attr:{'src':thumb}"></span>
        
			<?php if($authUser->Role=='Admin'){ ?>
    		<a class="remove" data-bind="click: $parent.showRemoveDialog">
                <i class="not-published fa fa-minus-circle fa-lg"></i>
            </a>
            <?php } ?>
            
    		<h2><a data-bind="text:name, attr: { 'href': editUrl }"></a> <span class="draft-tag" data-bind="visible:hasDraft"><?php print _("Draft"); ?></span></h2>
    		<p data-bind="text:description"></p>
    		<em><?php print _("Last updated"); ?> <span data-bind="text:friendlyDate"></span> <?php print _("by"); ?> <span data-bind="text:lastModifiedFullName"></span></em>
    		<?php if($authUser->Role=='Admin'){ ?>
    		<span class="status" data-bind="css: { 'published': isActive() == 1, 'not-published': isActive() == 0 }, click: $parent.toggleActive">
    			<i class="not-published fa fa-circle-o fa-lg"></i>
    			<i class="published fa fa-check-circle fa-lg"></i>
    		</span>
    		<?php } ?>
    	</div>
    	<!-- /.listItem -->
    
    </div>
    <!-- /.list -->
    
    <p data-bind="visible: pagesLoading()" class="list-loading"><i class="icon-spinner icon-spin"></i> Loading...</p>
    
    <p data-bind="visible: pagesLoading()==false && pages().length < 1" class="list-none"><?php print _("No pages here. Click Add Page to get started."); ?></p>
      
</section>
<!-- /.main -->

<div class="modal fade" id="addDialog">

	<div class="modal-dialog">
	
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3><?php print _("Add Page"); ?></h3>
			</div>
			<div class="modal-body">
				
				<div class="form-group">
					<label for="name" class="control-label"><?php print _("Name:"); ?></label>
					<input id="name" type="text" value="" maxlength="255" class="form-control">
				</div>
				
				<div class="form-group">
					<label for="URL" class="control-label"><?php print _("Friendly URL:"); ?></label>
					<input id="friendlyId" type="text" maxlength="128" value="" placeholder="page-name" class="form-control">
					<span class="help-block"><?php print _("No spaces, no special characters, dashes allowed."); ?></span>
				</div>
				
				<div class="form-group">
					<label for="description" class="control-label"><?php print _("Description:"); ?></label>
					<textarea id="description" class="form-control"></textarea>
				</div>
				
			</div>
			<div class="modal-footer">
				<button class="secondary-button" data-dismiss="modal"><?php print _("Close"); ?></button>
				<button class="primary-button" data-bind="click: addPage"><?php print _("Add Page"); ?></button>
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /.modal-content -->
		
	</div>
	<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<div class="modal fade" id="deleteDialog">

	<div class="modal-dialog">
	
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3><?php print _("Remove Page"); ?></h3>
			</div>
			<div class="modal-body">
			
			<p>
				<?php print _("Confirm that you want to remove:"); ?> <strong id="removeName">this page</strong>
			</p>
			
			</div>
			<div class="modal-footer">
				<button class="secondary-button" data-dismiss="modal"><?php print _("Close"); ?></button>
				<button class="primary-button" data-bind="click: removePage"><?php print _("Remove Page"); ?></button>
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /.modal-content -->
		
	</div>
	<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<div class="modal fade" id="deletePageTypeDialog">

	<div class="modal-dialog">
	
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3><?php print _("Remove Page Type"); ?></h3>
			</div>
			
			<div class="modal-body">
			
				<p>
					<?php print _("Confirm you want to remove:"); ?> <strong id="removePageTypeName">this page type</strong>
				</p>
				
			</div>
			
			<div class="modal-footer">
				<button class="secondary-button" data-dismiss="modal"><?php print _("Close"); ?></button>
				<button class="primary-button" data-bind="click: removePageType"><?php print _("Remove Type"); ?></button>
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /.modal-content -->
		
	</div>
	<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<div class="modal fade" id="pageTypeDialog">

	<div class="modal-dialog">
	
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h3 class="add"><?php print _("Add Page Type"); ?></h3>
				<h3 class="edit"><?php print _("Update Page Type"); ?></h3>
			</div>
			<!-- /.modal-header -->

			<div class="modal-body">
			
				<div class="form-group">
					<label for="typeS" class="control-label"><?php print _("Name (singular):"); ?></label>
					<input id="typeS"  value="" maxlength="100" class="form-control">
					<span class="add help-block"><?php print _("e.g.: Page, Blog, Product, etc."); ?></span>
				</div>
				
				<div class="form-group">
					<label for="typeP" class="control-label"><?php print _("Name (Plural):"); ?></label>
					<input id="typeP"  value="" maxlength="100" class="form-control">
					<span class="add help-block"><?php print _("e.g.: Pages, Blogs, Products, etc."); ?></span>
				</div>
				
				<div class="add form-group">
					<label for="typeFriendlyId" class="control-label"><?php print _("Friendly URL:"); ?></label>
					<input id="typeFriendlyId" value="" maxlength="50" class="form-control">
					<span class="add help-block">e.g. http://respondcms.com/[friendly-url]/. <?php print _("Must be lowercase with no spaces."); ?></span>
				</div>
				
				<div class="form-group">
					<label for="layout" class="control-label"><?php print _("Default Layout:"); ?></label>
					<select id="layout" data-bind="options: layouts, value: layout" class="form-control"></select>
				</div>
				
				<div class="form-group">
					<label for="stylesheet" class="control-label"><?php print _("Default Styles:"); ?></label>
					<select id="stylesheet" data-bind="options: stylesheets, value: stylesheet" class="form-control"></select>
				</div>
			
			</form>
			<!-- /.form-horizontal -->
			
			</div>
			<!-- /.modal-body -->
			
			<div class="modal-footer">
				<button class="secondary-button" data-dismiss="modal"><?php print _("Close"); ?></button>
				<button class="add primary-button" data-bind="click: addPageType"><?php print _("Add Type"); ?></button>
				<button class="edit primary-button" data-bind="click: editPageType"><?php print _("Update Type"); ?></button>
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /.modal-content -->
		
	</div>
	<!-- /.modal-dialog -->

</div>
<!-- /.modal -->
	
</body>

<!-- include js -->
<script type="text/javascript" src="<?php print JQUERY_JS; ?>"></script>
<script type="text/javascript" src="<?php print JQUERYUI_JS; ?>"></script>
<script type="text/javascript" src="<?php print BOOTSTRAP_JS; ?>"></script>
<script type="text/javascript" src="<?php print KNOCKOUT_JS; ?>"></script>
<script type="text/javascript" src="js/helper/moment.min.js?v=<?php print VERSION; ?>"></script>
<script type="text/javascript" src="js/helper/flipsnap.min.js?v=<?php print VERSION; ?>"></script>
<script type="text/javascript" src="js/global.js?v=<?php print VERSION; ?>"></script>
<script type="text/javascript" src="js/messages.js?v=<?php print VERSION; ?>"></script>
<script type="text/javascript" src="js/viewModels/models.js?v=<?php print VERSION; ?>"></script>
<script type="text/javascript" src="js/viewModels/pagesModel.js?v=<?php print VERSION; ?>" defer="defer"></script>

</html>