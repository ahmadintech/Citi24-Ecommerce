<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>CITi24 Email</title>
    <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */
        @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700&display=swap');
        
        body {
            width: 100% !important;
            height: 100%;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;
            line-height: 1.5;
            color: #51545E;
            background-color: #F2F4F6;
        }
        
        a {
            color: #3869D4;
            text-decoration: none;
        }
        
        a img {
            border: none;
        }
        
        td {
            word-break: break-word;
        }
        
        .preheader {
            display: none !important;
            visibility: hidden;
            mso-hide: all;
            font-size: 1px;
            line-height: 1px;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
        }
        
        /* Typography ------------------------------ */
        h1 {
            margin-top: 0;
            color: #22234f;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 20px;
        }
        
        h2 {
            margin-top: 0;
            color: #22234f;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        
        h3 {
            margin-top: 0;
            color: #22234f;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 14px;
        }
        
        p {
            margin: 0 0 16px 0;
            font-size: 16px;
            line-height: 1.6;
        }
        
        /* Layout ------------------------------ */
        .email-wrapper {
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #F2F4F6;
        }
        
        .email-content {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
        }
        
        .email-body {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        
        .email-body_inner {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #FFFFFF;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .content-cell {
            padding: 40px;
        }
        
        /* Header ------------------------------ */
        .email-masthead {
            padding: 30px 0;
            text-align: center;
            background-color: #22234f;
        }
        
        .email-masthead_logo {
            width: 120px;
            height: auto;
        }
        
        /* Footer ------------------------------ */
        .email-footer {
            width: 100%;
            max-width: 600px;
            margin: 20px auto 0;
            padding: 20px 0;
            text-align: center;
            font-size: 14px;
            color: #A8AAAF;
        }
        
        .social-links {
            margin: 20px 0;
            text-align: center;
        }
        
        /* Buttons ------------------------------ */
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #22234f;
            color: #FFFFFF !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            margin: 10px 0;
        }
        
        .button-secondary {
            background-color: #6c757d;
        }
        
        /* Utility Classes ------------------------------ */
        .text-center {
            text-align: center;
        }
        
        .text-muted {
            color: #6c757d;
        }
        
        .mt-0 { margin-top: 0 !important; }
        .mt-10 { margin-top: 10px !important; }
        .mt-20 { margin-top: 20px !important; }
        .mt-30 { margin-top: 30px !important; }
        
        .mb-0 { margin-bottom: 0 !important; }
        .mb-10 { margin-bottom: 10px !important; }
        .mb-20 { margin-bottom: 20px !important; }
        .mb-30 { margin-bottom: 30px !important; }
        
        /* Social Icons ------------------------------ */
        .social-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            text-align: center;
            color: white !important;
            margin: 0 5px;
            font-size: 18px;
        }
        
        .twitter { background-color: #55ACEE; }
        .youtube { background-color: #bb0000; }
        .instagram { background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D); }
        .whatsapp { background-color: #25D366; }
        .telegram { background-color: #0088cc; }
        
        /* Responsive ------------------------------ */
        @media only screen and (max-width: 640px) {
            .content-cell {
                padding: 30px 20px !important;
            }
            
            h1 {
                font-size: 22px !important;
            }
            
            h2 {
                font-size: 18px !important;
            }
        }
        
        /* Dark Mode ------------------------------ */
        @media (prefers-color-scheme: dark) {
            body, 
            .email-body, 
            .email-body_inner, 
            .email-content, 
            .email-wrapper {
                background-color: #222222 !important;
                color: #e0e0e0 !important;
            }
            
            .email-body_inner {
                background-color: #333333 !important;
            }
            
            h1, h2, h3, h4 {
                color: #ffffff !important;
            }
            
            p, ul, ol, blockquote {
                color: #e0e0e0 !important;
            }
            
            .email-masthead {
                background-color: #dae6e5 !important;
            }
            
            .button {
                background-color: #3a3a7d !important;
            }
        }
    </style>
</head>

<body>
    <span class="preheader"></span>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Header -->
                    <tr>
                        <td class="email-masthead">
                            <img src="https://app.citi24.com.ng/logo.png" alt="CITi24 Logo" class="email-masthead_logo">
                        </td>
                    </tr>
                    
                    <!-- Email Body -->
                    <tr>
                        <td class="email-body" width="100%">
                            <table class="email-body_inner" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        <div class="f-fallback">
                                            {!! $body !!}
                                            
                                            <p class="mt-30">Best regards,<br>The CITi24 Team</p>
                                            
                                            <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td align="center">
                                                        <!-- Any call-to-action buttons can go here -->
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td>
                            <table class="email-footer" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="content-cell" align="center">
                                        <div class="social-links">
                                            <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                                            <a href="#" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
                                            <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                                            <a href="#" class="social-icon whatsapp"><i class="fab fa-whatsapp"></i></a>
                                            <a href="#" class="social-icon telegram"><i class="fab fa-telegram"></i></a>
                                        </div>
                                        
                                        <p class="text-muted">© 2025 CITi24. All rights reserved.</p>
                                        <p class="text-muted mb-0">
                                            <a href="#" style="color: #6c757d;">Privacy Policy</a> | 
                                            <a href="#" style="color: #6c757d;">Terms of Service</a> | 
                                            <a href="#" style="color: #6c757d;">Contact Us</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>