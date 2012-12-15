<?php // echo "<pre>"; var_dump($page_items); die(); ?>

<div class="row clearfix:after pages_list">
	
	<div class="span3 bs-docs-sidebar">

		<ul class="nav nav-list bs-docs-sidenav affix-top">
			<li><a href="<?php echo base_url('admin/pages'); ?>">Pages</a></li>
			<li><a href="<?php echo base_url('admin/pages/create_page'); ?>">Create a page</a></li>
		</ul>
		
	</div>

	<div class="span9">
		<section id="pages">
			<div class="controlgroup">

				<table class="table table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Content</th>
							<th>Modified Date</th>
						</tr>
					</thead>
					<tbody>

						<?php if ( is_array($page_items)) : foreach ($page_items as $pages) : ?>		
						
							<tr>
								<td><?php echo $pages['page_id']; ?></td>
								<td><?php echo $pages['title']; ?></td>
								<td><?php echo $pages['content']; ?></td>
								<td><?php echo $pages['modified']; ?></td>
							</tr>
						
						<?php endforeach; endif; ?>				

					</tbody>
				</table>				
				

			</div>
			
		</section>

	</div>	

</div>