<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<style type="text/css">
			a:link, a:visited {color: #1b76e6; text-decoration: none;}
			.text {font-size: 12px; font-family: Tahoma; color: #4a4a4a; line-height: 16px;}
		</style>
	</head>
	<body>
	
<?php
	define('access', true);
	include('includes/xinc_config.php');

	$newsquery = 	odbc_exec($odbc_connect, 'SELECT TOP 6 [title] FROM [' . $_CONFIG['db_databases']['web'] . '].[dbo].[web_news] ORDER BY datetime DESC');
	$accounts = 	odbc_exec($odbc_connect, 'SELECT COUNT([account]) as count FROM [' . $_CONFIG['db_databases']['acc'] . '].[dbo].[ACCOUNT_TBL]');
	$peak = 		odbc_result(@odbc_exec($odbc_connect, 'SELECT TOP 1 number FROM [' . $_CONFIG['db_databases']['log'] . '].[dbo].[LOG_USER_CNT_TBL] ORDER BY [number] DESC'), 'number');
	$onlineplayer = odbc_exec($odbc_connect, 'SELECT COUNT([m_szName]) as count FROM [' . $_CONFIG['db_databases']['chr'] . '].[dbo].[CHARACTER_TBL] WHERE [MultiServer] > 0 AND [isblock] != \'D\'');
	$characters = 	odbc_exec($odbc_connect, 'SELECT COUNT([m_szName]) as count FROM [' . $_CONFIG['db_databases']['chr'] . '].[dbo].[CHARACTER_TBL] WHERE [isblock] != \'D\'');
	$guilds = 		odbc_exec($odbc_connect, 'SELECT COUNT(*) as count FROM [' . $_CONFIG['db_databases']['chr'] . '].[dbo].[GUILD_TBL]');
	if(@fsockopen('45.137.117.220', 23000, $errno, $errstr, 1)) {$status = '<font style="color:#258a2a;">Online</font>';} else {$status = '<font style="color:#ff0000;">Offline</font>';}
?>

		<table width="380px" height="150px" cellspacing="1" cellpadding="2">
			<tr>
				<td width="67%" align="left" valign="top" class="text">
				<b>Neuigkeiten:</b>
				<?php
					while($news = @odbc_fetch_array($newsquery)) {
						if(strlen($news['title']) > 36) {
							$news['title'] = substr($news['title'], 0, 36).'...';
						}
						echo '<br />&bull; '.$news['title'];
					}
				?>
				</td>
				<td width="33%" align="left" valign="top" class="text">
					<b>Informationen:</b><br />
					<label style="width:80px; float:left;">&bull; Status:</label>		<?php echo $status; ?><br />
					<label style="width:80px; float:left;">&bull; User online:</label> 	<?php echo odbc_result($onlineplayer, 'count'); ?><br />
					<label style="width:80px; float:left;">&bull; Accounts:</label> 	<?php echo odbc_result($accounts, 'count'); ?><br />
					<label style="width:80px; float:left;">&bull; Charaktere:</label> 	<?php echo odbc_result($characters, 'count'); ?><br />
					<label style="width:80px; float:left;">&bull; Gilden:</label>		<?php echo odbc_result($guilds, 'count'); ?><br />
				</td>
			</tr>
			<tr>
				<td style="font-size:11px;" class="text" colspan="2" align="center" valign="bottom">
					<b>Besuche <a href="http://www.tropical-island.eu/" target="_blank">Tropical Island</a> f&uuml;r mehr Informationen.</b>
				</td>
			</tr>
		</table>
	</body>
</html>