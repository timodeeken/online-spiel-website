USE [WEB_DBF]
GO

/****** Object:  StoredProcedure [dbo].[usp_CreateIngameAccount]    Script Date: 12.01.2021 14:41:51 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


CREATE proc [dbo].[usp_CreateIngameAccount]
@account varchar(32),
@uuid varchar(255) = '',
@state int = 0,
@create_date datetime
as
set nocount on
set xact_abort on

if not exists (select * from WEB_ACC where account = @account)
begin


	begin tran
	INSERT WEB_ACC_INGAME(uuid,account,state, create_date)
	VALUES(@uuid, @account, @state, @create_date)
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
else
begin
	select 0
end

GO


