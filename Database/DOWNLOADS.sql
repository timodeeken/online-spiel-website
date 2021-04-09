USE [WEB_DBF]
GO

/****** Object:  Table [dbo].[WEB_ACC]    Script Date: 12.01.2021 14:38:29 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[DOWNLOADS](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[download_title] [varchar](50) NOT NULL,
	[download_link] [varchar](100) NULL,
	[download_size] [varchar](25) NOT NULL,
    [download_host] [varchar](50) NULL,
    [download_uuid] [varchar](50) NULL,
	[create_date] [datetime] NULL,
	[state] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


