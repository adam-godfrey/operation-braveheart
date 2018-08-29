<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<div id="adminpanel">
				<div class="row">
					<div class="col-sm-6 col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft newsicon">
							<p><span><a href="<?=URL;?>admin/news">News</a></span></p>
							<p><a href="<?=URL;?>admin/news/add">Add a news item</a></p>
							<p><a href="<?=URL;?>admin/news/edit">Edit a news item</a></p>
							<p><a href="<?=URL;?>admin/news/delete">Delete a news item</a></p>
							<p><a href="<?=URL;?>admin/news/archive">Archive a news item</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright blogsicon">
							<p><span><a href="<?=URL;?>admin/blogs">Blogs</a></span></p>
							<p><a href="<?=URL;?>admin/blogs/add">Add a blog item</a></p>
							<p><a href="<?=URL;?>admin/blogs/edit">Edit a blog item</a></p>
							<p><a href="<?=URL;?>admin/blogs/delete">Delete a blog item</a></p>
							<p><a href="<?=URL;?>admin/blogs/archive">Archive a blog item</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft eventsicon">
							<p><span><a href="<?=URL;?>admin/events">Events</a></span></p>
							<p><a href="<?=URL;?>admin/events/add">Add an event</a></p>
							<p><a href="<?=URL;?>admin/events/edit">Edit an event</a></p>
							<p><a href="<?=URL;?>admin/events/delete">Delete an event</a></p>
							<p><a href="<?=URL;?>admin/events/archive">Archive an event</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright articlesicon">
							<p><span><a href="<?=URL;?>admin/articles">Articles</a></span></p>
							<p><a href="<?=URL;?>admin/articles/add">Add an article</a></p>
							<p><a href="<?=URL;?>admin/articles/edit">Edit an article</a></p>
							<p><a href="<?=URL;?>admin/articles/delete">Delete an article</a></p>
							<p><a href="<?=URL;?>admin/articles/archive">Archive an article</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft homeicon">
							<p><span><a href="<?=URL;?>admin/home-page">Home Page</a></span></p>
							<p><a href="<?=URL;?>admin/home-page">Edit the home page</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright fundicon">
							<p><span><a href="<?=URL;?>admin/current-fund">Current Fund</a></span></p>
							<p><a href="<?=URL;?>admin/current-fund">Update the current fund amount</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft shopicon">
							<p><span><a href="<?=URL;?>admin/shop">Shop</a></span></p>
							<p><a href="<?=URL;?>admin/shop/add">Add a shop product</a></p>
							<p><a href="<?=URL;?>admin/shop/edit">Edit a shop product</a></p>
							<p><a href="<?=URL;?>admin/shop/delete">Delete a shop product</a></p>
							<p><a href="<?=URL;?>admin/shop/disable">Disable a shop product</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright commentsicon">
							<p><span><a href="<?=URL;?>admin/comments">Comments <?php if($this->comments > 0): ?><span class="badge"><?=$this->comments;?></span><?php endif; ?></a></span></p>
							<p><a href="<?=URL;?>admin/comments">Moderate a comment</a></p>
							<p><a href="<?=URL;?>admin/comments/publish">Publish a comment</a></p>
							<p><a href="<?=URL;?>admin/comments/delete">Delete a comment</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft analyticsicon">
							<p><span><a href="<?=URL;?>admin/analytics">Site Analytics</a></span></p>
							<p><a href="<?=URL;?>admin/analytics">View Current Site Analytics, Page Views and Users Online</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright cacheicon">
							<p><span><a href="<?=URL;?>admin/manage-cache">Website Cache</a></span></p>
							<p><a href="<?=URL;?>admin/manage-cache">Manage website cache</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft sponsoricon">
							<p><span><a href="<?=URL;?>admin/sponsors">Sponsors</a></span></p>
							<p><a href="<?=URL;?>admin/sponsors/add">Add a sponsor</a></p>
							<p><a href="<?=URL;?>admin/sponsors/edit">Edit a sponsor</a></p>
							<p><a href="<?=URL;?>admin/sponsors/delete">Delete a sponsor</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright linksicon">
							<p><span><a href="<?=URL;?>admin/links">Links</a></span></p>
							<p><a href="<?=URL;?>admin/links/add">Add a link</a></p>
							<p><a href="<?=URL;?>admin/links/edit">Edit a link</a></p>
							<p><a href="<?=URL;?>admin/links/delete">Delete a link</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft galleryicon">
							<p><span><a href="<?=URL;?>admin/gallery">Image Gallery</a></span></p>
							<p><a href="<?=URL;?>admin/gallery/add">Add an image to the gallery</a></p>
							<p><a href="<?=URL;?>admin/gallery/edit">Edit an image in the gallery</a></p>
							<p><a href="<?=URL;?>admin/gallery/delete">Delete an image from the gallery</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright poemsicon">
							<p><span><a href="<?=URL;?>admin/poems">Poems</a></span></p>
							<p><a href="<?=URL;?>admin/poems/add">Add a poem</a></p>
							<p><a href="<?=URL;?>admin/poems/edit">Edit a poem</a></p>
							<p><a href="<?=URL;?>admin/poems/delete">Delete a poem</a></p>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft emailicon">
							<p><span><a href="<?=URL;?>admin/emails">Emails <?php if($this->emails > 0): ?><span class="badge"><?=$this->emails;?></span><?php endif; ?></a></span></p>
							<p><a href="<?=URL;?>admin/emails/create">Create a new email</a></p>
							<p><a href="<?=URL;?>admin/emails/edit">Edit an email</a></p>
							<p><a href="<?=URL;?>admin/emails/delete">Delete an email</a></p>
							<p><a href="<?=URL;?>admin/emails/archive">Archive an email</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright newslettericon">
							<p><span><a href="<?=URL;?>admin/newsletters">Newsletters</a></span></p>
							<p><a href="<?=URL;?>admin/newsletters/create">Create a newsletter</a></p>
							<p><a href="<?=URL;?>admin/newsletters/edit">Edit a newsletter</a></p>
							<p><a href="<?=URL;?>admin/newsletters/delete">Delete a newsletter</a></p>
							<p><a href="<?=URL;?>admin/newsletters/archive">Archive a newsletter</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeleft videoicon">
							<p><span><a href="<?=URL;?>admin/videos">Video</a></span></p>
							<p><a href="<?=URL;?>admin/videos/upload">Upload a video</a></p>
							<p><a href="<?=URL;?>admin/videos/delete">Delete a video</a></p>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 adminhome">
						<div class="adminhomeright lotteryicon">
							<p><span><a href="<?=URL;?>">Lottery Video</a></span></p>
							<p><a href="<?=URL;?>admin/lottery-video/upload">Upload a lottery video</a></p>
							<p><a href="<?=URL;?>admin/lottery-video/delete">Delete a lottery video</a></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 adminhome">
						<div class="adminhomefull forumicon">
							<p><span><a href="<?=URL;?>admin/forums">Forums</a></span></p>
							<p><a href="<?=URL;?>admin/forum-boards/add">Add a new board to the forum</a></p>
							<p><a href="<?=URL;?>admin/forum-boards/delete">Delete a board from the forum</a></p>
							<p><a href="<?=URL;?>admin/forum-flagged-posts">View a message in the forum flagged as inappropiate <?php if($this->flagged > 0): ?><span class="badge"><?=$this->flagged;?></span><?php endif; ?></a></p>
							<p><a href="<?=URL;?>admin/forum-flagged-posts/delete">Delete a message in the forum flagged as inappropiate <?php if($this->flagged > 0): ?><span class="badge"><?=$this->flagged;?></span><?php endif; ?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>