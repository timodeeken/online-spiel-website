USE [WEB_DBF]
GO

/****** Object:  StoredProcedure [dbo].[usp_CreateNewAccount]    Script Date: 12.01.2021 14:40:05 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE proc [dbo].[usp_CreateNewAccount]
@account varchar(32),
@pw varchar(50),
@nickname varchar(32),
@email varchar(255) = '',
@question varchar(255) = '',
@answer varchar(255) = '',
@birthday datetime,
@newsletter varchar(255) = 'off',
@uuid varchar(255) = '',
@votepoints int = 0,
@donatepoints int = 0,
@create_date datetime
as
set nocount on
set xact_abort on

if not exists (select * from WEB_ACC where account = @account)
begin


	begin tran
	INSERT WEB_ACC(account,nickname,password,mail,question,answer,birthday,newsletter,uuid, votepoints, donatepoints, create_date)
	VALUES(@account, @nickname, @pw, @email, @question, @answer, @birthday, @newsletter, @uuid, @votepoints,@donatepoints ,@create_date)

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


