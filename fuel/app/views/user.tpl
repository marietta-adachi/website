<h1>{$title}</h1>


{foreach $user_list item=row}
	{$row->user_email}
	{$row->get_email()}
	{*$row.user_id}&nbsp;
	{$row.user_name}&nbsp;
	{$row.user_email}&nbsp;
	{$row.user_status*}&nbsp;
	<br/>
{/foreach}