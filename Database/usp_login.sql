
USE [WEB_DBF]
GO

/****** Object:  StoredProcedure [dbo].[usp_WebLogin]    Script Date: 12.01.2021 14:41:04 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:              Sedrika
-- Create date: 04/28/2015
-- Description: Login Procedure
--
-- @retval
-- - 0: Login failed due to wrong password or account name
-- - 1: Login was successful
-- - 2: IP has been blocked for X minutes
--
-- @iMaxFailCount
-- - Max amount of invalid logins
--
-- @iBlockTime
-- - Blocktime in seconds
-- - 60 = 1 minute
-- =============================================
CREATE PROCEDURE [dbo].[usp_WebLogin]
        @account VARCHAR(16),
        @password VARCHAR(32),
        @remoteip VARCHAR(15)
AS
BEGIN
        SET NOCOUNT ON;
 
        -- Declarations (edit here)
        DECLARE @iMaxFailCount INT = 3
        DECLARE @iBlockTime INT = 600
 
        -- Declarations (do not edit below this)
        DECLARE @retval VARCHAR(1) = '0'
        DECLARE @szPassword VARCHAR(32)
        DECLARE @iFirstLogin INT
        DECLARE @iFailCount INT
        DECLARE @cTimeStamp INT = (SELECT DATEDIFF(s, '19700101', GETDATE()))
 
        /*
                Check if @remoteip is already in our blocklist and if it's
                amount of invalid logins over @iMaxFailCount
        */
        IF EXISTS(SELECT * FROM [tblLoginLog] WHERE [RemoteIP] = @remoteip)
                BEGIN
                        SET @iFirstLogin = (SELECT [FirstLogin] FROM [tblLoginLog] WHERE [RemoteIP] = @remoteip)
                        SET @iFailCount = (SELECT [FailCount] FROM [tblLoginLog] WHERE [RemoteIP] = @remoteip)
 
                        IF @iFailCount >= @iMaxFailCount AND @cTimeStamp - @iFirstLogin < @iBlockTime
                                BEGIN
                                        SET @retval = '2'
                                END
                END
 
        /*
                Check if login is valid or not
        */
        IF @retval = '0'
                BEGIN
                        IF EXISTS(SELECT * FROM [WEBDB_DBF].[dbo].[WEB_ACC] WHERE [account] = @account)
                                BEGIN
                                        SET @szPassword = (SELECT [password] FROM [WEBDB_DBF].[dbo].[WEB_ACC] WHERE [account] = @account)
                                        IF @szPassword = @password
                                                BEGIN
                                                        SET @retval = '1'
                                                END
                                        ELSE
                                                BEGIN
                                                        SET @retval = '0'
                                                END
                                END
                        ELSE
                                BEGIN
                                        SET @retval = '0'
                                END
                END
 
        /*
                If login is not valid then increase the counter
        */
        IF @retval = '0'
                BEGIN
                        IF EXISTS(SELECT * FROM [tblLoginLog] WHERE [RemoteIP] = @remoteip)
                                BEGIN
                                        SET @iFirstLogin = (SELECT [FirstLogin] FROM [tblLoginLog] WHERE [RemoteIP] = @remoteip)
                                        SET @iFailCount = (SELECT [FailCount] FROM [tblLoginLog] WHERE [RemoteIP] = @remoteip)
 
                                        IF @iFailCount >= @iMaxFailCount AND @cTimeStamp - @iFirstLogin < @iBlockTime
                                                BEGIN
                                                        SET @retval = '2'
                                                END
                                        ELSE
                                                BEGIN
                                                        IF @cTimeStamp - @iFirstLogin >= @iBlockTime
                                                                BEGIN
                                                                        UPDATE [tblLoginLog] SET [FirstLogin] = @cTimeStamp, [FailCount] = 1 WHERE [RemoteIP] = @remoteip
                                                                END
                                                        ELSE
                                                                BEGIN
                                                                        UPDATE [tblLoginLog] SET [FailCount] = ([FailCount] + 1) WHERE [RemoteIP] = @remoteip
                                                                END
                                                END
                                END
                        ELSE
                                BEGIN
                                        INSERT INTO [tblLoginLog] ([FirstLogin], [FailCount], [RemoteIP]) VALUES (@cTimeStamp, 1, @remoteip)
                                END
                END
        ELSE
                BEGIN
                        IF EXISTS(SELECT * FROM [tblLoginLog] WHERE [RemoteIP] = @remoteip) AND @retval = '1'
                                BEGIN
                                        UPDATE [tblLoginLog] SET [FailCount] = 0 WHERE [RemoteIP] = @remoteip
                                END
                END
 
        SELECT @retval AS 'retval'
END
GO


