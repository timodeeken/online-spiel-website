USE [WEB_DBF]
GO

/****** Object:  StoredProcedure [dbo].[usp_CreateNewAccount]    Script Date: 12.01.2021 14:40:05 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE proc [dbo].[usp_add_news]
@news_title varchar(50),
@news_text varchar(max),
@author varchar(25),
@create_date datetime,,
@category int = 1,
as
set nocount on
set xact_abort on

	begin tran
	INSERT NEWS(news_text,news_title,author,create_date,category)
	VALUES(@news_title, @news_text, @author, @create_date, @category)

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


