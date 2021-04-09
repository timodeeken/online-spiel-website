USE [WEB_DBF]
GO

/****** Object:  Table [dbo].[WEB_ACC]    Script Date: 12.01.2021 14:38:29 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[WEB_ACC](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[account] [varchar](50) NOT NULL,
	[nickname] [varchar](50) NULL,
	[password] [varchar](255) NOT NULL,
	[mail] [varchar](255) NOT NULL,
	[question] [varchar](255) NOT NULL,
	[answer] [varchar](255) NOT NULL,
	[birthday] [datetime] NOT NULL,
	[newsletter] [varchar](3) NULL,
	[uuid] [varchar](255) NOT NULL,
	[state] [int] NULL,
	[votepoints] [int] NULL,
	[donatepoints] [int] NULL,
	[create_date] [datetime] NULL,
	[auth] [varchar](1) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

ALTER TABLE [dbo].[WEB_ACC] ADD  CONSTRAINT [DF_WEB_ACC_newsletter]  DEFAULT ('off') FOR [newsletter]
GO

ALTER TABLE [dbo].[WEB_ACC] ADD  CONSTRAINT [DF_WEB_ACC_state]  DEFAULT ((0)) FOR [state]
GO

ALTER TABLE [dbo].[WEB_ACC] ADD  CONSTRAINT [DF_WEB_ACC_auth]  DEFAULT ('F') FOR [auth]
GO


