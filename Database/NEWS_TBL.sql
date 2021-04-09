USE [WEB_DBF]
GO

/****** Object:  Table [dbo].[WEB_ACC]    Script Date: 12.01.2021 14:38:29 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[NEWS](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[news_title] [varchar](50) NOT NULL,
	[news_text] [varchar](max) NULL,
	[author] [varchar](25) NOT NULL,
	[create_date] [datetime] NULL,
	[category] [int](1) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


