USE [WEB_DBF]
GO

/****** Object:  Table [dbo].[WEB_ACC]    Script Date: 12.01.2021 14:38:29 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[TICKETSYSTEM](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[ticket_title] [varchar](50) NOT NULL,
	[ticket_text] [varchar](max) NULL,
	[ticket_category] [int] NOT NULL,
    [ticket_user] [varchar](25) NULL,
    [ticket_processor] [varchar](25) NULL,
    [ticket_uuid] [varchar](25) NULL,
    [ticket_attachment] [varchar](100) NULL,
    [ticket_state] [int] NULL,
	[ticket_date] [datetime] NULL
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


USE [WEB_DBF]
GO

/****** Object:  Table [dbo].[WEB_ACC]    Script Date: 12.01.2021 14:38:29 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[TICKETSYSTEM_MESSAGES](
	[id] [int] IDENTITY(1,1) NOT NULL,
    [ticket_uuid] [varchar](25) NULL,
    [ticket_messages] [varchar](max) NULL,
    [ticket_message_by] [varchar](max) NOT NULL,
	[ticket_date] [datetime] NULL
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


