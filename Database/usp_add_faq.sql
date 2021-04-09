USE [WEB_DBF]
GO

/****** Object:  StoredProcedure [dbo].[usp_CreateNewAccount]    Script Date: 12.01.2021 14:40:05 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE proc [dbo].[usp_add_faq]
@faq_question varchar(50),
@faq_answer varchar(max),
@author varchar(25),
@faq_uuid varchar(25),
@create_date datetime,
@state int = 1
as
set nocount on
set xact_abort on

	begin tran
	INSERT FAQ(faq_question,faq_answer,author,create_date,state)
	VALUES(@faq_question, @faq_answer, @author, @create_date, @state)

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


