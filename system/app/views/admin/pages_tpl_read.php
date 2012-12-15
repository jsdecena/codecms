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