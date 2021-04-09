USE [WEB_DBF]
GO

/****** Object:  Table [dbo].[tblLoginLog]    Script Date: 15.01.2021 23:16:36 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[tblLoginLog](
	[SEQ] [int] IDENTITY(1,1) NOT NULL,
	[FirstLogin] [int] NOT NULL,
	[FailCount] [int] NOT NULL,
	[RemoteIP] [varchar](15) NOT NULL
) ON [PRIMARY]
GO


