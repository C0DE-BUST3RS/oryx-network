<?php

function resetPasswordEmailTemplate($url)
{
	$body = '
	<ul id="bbt-builder-container" class="builder-module-list ui-sortable">
					                <li class="email-element editing-module" data-module-id="235064">
                    
    <table class="wrapper_table" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; max-width: 800px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
      
        <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
            <td class="bluebg" data-color-bluebg="background-color" align="center" height="100" valign="top" width="100%" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;background-color: #5479ff" bgcolor="#5479ff" data-resized="NaN">
                <!--[if mso]>
                <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="800">
                <tr>
                <td align="center" valign="top" width="800">
                <![endif]-->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; max-width: 620px;">
                    <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                        <td align="center" valign="top" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 0;">
                            <!--[if mso]>
                            <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="620">
                            <tr>
                            <td align="left" valign="top" width="620">
                            <![endif]-->
                            <div style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; display: inline-block; margin: 0 -2px; max-width: 100%; min-width: 226px; vertical-align: top; width: 100%;" class="stack-column">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                    <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                        <td style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding: 10px 10px 0;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 14px; text-align: left;">
                                                <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                    <td style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                    <div style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                        <table cellspacing="0" cellpadding="0" border="0" class="mobile_centered_table" align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                            <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td height="34" class="space_class" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 1px; line-height: 1px;"> &nbsp;
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                    <a href="#" target="_blank" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; text-decoration: none !important;">
                                                                        <img src="https://i.imgur.com/IawN3CR.png" width="120" style="text-size-adjust: 100%; border: 0px; display: block; max-width: 120px; width: 100%;" class="center-on-narrow" alt="" height="120" title="">  
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td height="59" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" class="">
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-bottom: 3px;">
                                                                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                           <td height="4" width="565" class="whitebg space_class" data-color-whitebg="background-color" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 5px; font-size: 1px; line-height: 1px;" bgcolor="#ffffff">&nbsp;
                                                                           </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-bottom: 3px;">
                                                                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                           <td height="4" width="585" class="whitebg space_class" data-color-whitebg="background-color" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 5px; font-size: 1px; line-height: 1px;" bgcolor="#ffffff">&nbsp;
                                                                           </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </div>
                                                    </td>
                                                </tr>
                                                <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                    <td class="whitebg" data-color-whitebg="background-color" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 3px;" bgcolor="#ffffff">
                                                        <table cellspacing="0" cellpadding="0" border="0" class="mobile_centered_table" align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                            <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td height="63" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" class="">
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td class="roboto weight400 text21" data-editable="" data-color-text21="color" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #212121; font-family: \'Roboto\', sans-serif; font-size: 32px; font-weight: 400; line-height: 32px;" align="center">
                                                                    Password Reset
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td height="28" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" class="">
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td class="roboto weight400 greytext9b" data-editable="" data-color-greytext9b="color" data-font-paragraph="" data-line-paragraph="" style="text-size-adjust: 100%; color: rgb(155, 155, 155); font-family: Roboto, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px;" align="center">We’ve received a request to have your password reset <span class="nomobile" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"> <br style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"></span> for <a class="bluetext" style="text-size-adjust: 100%; text-decoration: none !important; color: #5479ff;" href="https://www.oryx.network.nl" target="_blank" rel="noopener" data-color-bluetext="color"> oryx.network</a>. If you ignore this message,<span class="nomobile" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"> <br style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"></span> your password wont be changed.</td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td height="45" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" class="">
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                    <table cellspacing="0" cellpadding="0" border="0" class="mobile_centered_table" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                            <td align="center" data-editable="button" class="button block pinkbg" width="206" height="50" data-color-buttonpinkbg="background-color" style="text-size-adjust: 100%; background-color: rgb(249, 159, 34); border-color: rgb(63, 63, 63); border-radius: 35px; border-width: 0px;" bgcolor="#f99f22">
                                                                                <table cellspacing="0" cellpadding="0" border="0" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                                    <tbody><tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                                        <td class="roboto weight_500 whitetext uppercase" data-color-whitetext="color" align="center" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: \'Roboto\', sans-serif; font-size: 18px; text-decoration: none; text-transform: uppercase;">
                                                                                            <a data-color-buttonwhitetext="color" href='.$url.' target="_blank" class="whitetext block" style="text-size-adjust: 100%; color: rgb(255, 255, 255); text-decoration: none !important; line-height: 50px;">
                                                                                               reset password
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody></table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td height="37" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" class="">
                                                                </td>
                                                            </tr>
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td class="roboto weight400 greytext9b paddingleft10 paddingright10" data-editable="" data-color-greytext9b="color" data-font-paragraph="" data-line-paragraph="" style="text-size-adjust: 100%; color: rgb(155, 155, 155); font-family: Roboto, sans-serif; font-size: 14px; font-weight: 400; line-height: 21px;" align="center">If you didn’t request a password reset, <span class="nomobile" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"> <br style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"></span> <a class="bluetext" style="text-size-adjust: 100%; text-decoration: none !important; color: #5479ff;" href="https://www.oryx.network/contact" target="_blank" rel="noopener" data-color-bluetext="color">please let us know immediately.</a></td>
                                                            </tr>
                                                              
                                                            <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                                                                <td height="34" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" class="">
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </div>
                            <!--[if mso]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                    <tr style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                        <td height="148" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" class="">
                        </td>
                    </tr>
                </tbody></table>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
     
    </tbody></table>
 </li>
</ul>
	';

	return $body;
}