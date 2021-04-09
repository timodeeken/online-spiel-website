USE [WEB_DBF]
GO

/****** Object:  StoredProcedure [dbo].[usp_CreateNewAccount]    Script Date: 12.01.2021 14:40:05 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE proc [dbo].[usp_add_downloads]
@download_title varchar(50),
@download_link varchar(100),
@download_size varchar(25),
@download_host varchar(50),
@create_date datetime,,
@state int = 1,
as
set nocount on
set xact_abort on

	begin tran
	INSERT DOWNLOADS(download_title,download_link,download_size, download_host,create_date,state)
	VALUES(@download_title, @download_link, @download_size, @download_host, @create_date, @state)

	if @@error <> 0
	begin
		rollback tran
		select -1
	end
	else
	begin
		commit tran
		select 1
	end
end

GO


