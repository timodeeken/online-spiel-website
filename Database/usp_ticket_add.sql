USE [WEB_DBF]
GO

/****** Object:  StoredProcedure [dbo].[usp_CreateNewAccount]    Script Date: 12.01.2021 14:40:05 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE proc [dbo].[usp_ticket_add]
@ticket_title varchar(50),
@ticket_text varchar(max),
@ticket_category int,
@ticket_user varchar(25),
@ticket_processor varchar(25) = 'ALL',
@ticket_uuid varchar(25),
@ticket_attachment varchar(100),
@ticket_state int = 1,
@ticket_date datetime
as
set nocount on
set xact_abort on

	begin tran
	INSERT TICKETSYSTEM(ticket_title,ticket_text,ticket_user,ticket_processor,ticket_uuid, ticket_attachment, ticket_state, ticket_date)
	VALUES(@ticket_title, @ticket_text, @ticket_user, @ticket_processor, @ticket_uuid, @ticket_attachment, @ticket_state, @ticket_date)

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

GO


