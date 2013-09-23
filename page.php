<?php
session_start();
include('global.php');
include('include/functions.php');

$PageID=decrypt($_REQUEST['PageID'],$Encrypt);

$sel_page="select * from ".$tbname."_cms where _ID='".$PageID."' ";
$qr_page=mysql_query($sel_page);
$rs_page=mysql_fetch_array($qr_page);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
</head>

<body>

  <?php
  	include('header.php');
  ?>
  <!--main_header end-->
  
  <div class="main_login philosophy" style="min-height:auto;">
    <!--<h1 class="page-head"><?php echo $rs_page['_Title']; ?></h1>
    <div class="terms"><?php echo replaceSpecialCharBack($rs_page['_Title']); ?></div>-->
	
    <div class="terms">
	<h4><u>Terms and Conditions</u></h4><br />
	<p>Agreement between user and www.prthenon.com</p><br />
	<p>Welcome to www.prthenon.com. The www.prthenon.com website (the "Site") is comprised of various web pages operated by Prthenon. www.prthenon.com is offered to you conditioned on your acceptance without modification of the terms, conditions, and notices contained herein (the "Terms"). Your use of www.prthenon.com constitutes your agreement to all such Terms. Please read these terms carefully, and keep a copy of them for your reference.</p><br />
	<p>www.prthenon.com is a website created to connect like-minded users to one another so they can exchange reviews that are relevant to them.</p><br />
	
	<h4><u>Electronic Communications</u></h4><br />
	<p>Visiting www.prthenon.com or sending emails to Prthenon constitutes electronic communications. You consent to receive electronic communications and you agree that all agreements, notices, disclosures and other communications that we provide to you electronically, via email and on the site, satisfy any legal requirement that such communications be in writing.</p><br />
	
	<h4><u>Your account</u></h4><br />
	<p>If you use this site, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer, and you agree to accept responsibility for all activities that occur under your account or password. You may not assign or otherwise transfer your account to any other person or entity. You acknowledge that Prthenon is not responsible for third party access to your account that results from theft or misappropriation of your account.</p><br />
	<p>Prthenon and its associates reserve the right to refuse or cancel service, terminate accounts, or remove or edit content in our sole discretion.</p><br />
	<p>Prthenon does not knowingly collect, either online or offline, personal information from persons under the age of thirteen. If you are under 18, you may use www.prthenon.com only with permission of a parent or guardian.</p><br />
	<p>Links to third party sites/Third party services www.prthenon.com may contain links to other websites ("Linked Sites"). The Linked Sites are not under the control of Prthenon and Prthenon is not responsible for the contents of any Linked Site, including without limitation any link contained in a Linked Site, or any changes or updates to a Linked Site. Prthenon is providing these links to you only as a convenience, and the inclusion of any link does not imply endorsement by Prthenon of the site or any association with its operators.</p><br />
	<p>Certain services made available via www.prthenon.com are delivered by third party sites and organizations. By using any product, service or functionality originating from the www.prthenon.com domain, you hereby acknowledge and consent that Prthenon may share such information and data with any third party with whom Prthenon has a contractual relationship to provide the requested product, service or functionality on behalf of www.prthenon.com users and customers.</p><br />
	<p>No unlawful or prohibited use/Intellectual Property you are granted a non-exclusive, non-transferable, revocable license to access and use www.prthenon.com strictly in accordance with these terms of use. As a condition of your use of the Site, you warrant to Prthenon that you will not use the Site for any purpose that is unlawful or prohibited by these Terms. You may not use the Site in any manner which could damage, disable, overburden, or impair the Site or interfere with any other party's use and enjoyment of the Site.</p><br />
	<p>You may not obtain or attempt to obtain any materials or information through any means not intentionally made available or provided for through the Site. All content included as part of the Service, such as text, graphics, logos, images, as well as the compilation thereof, and any software used on the Site, is the property of Prthenon or its suppliers and protected by copyright and other laws that protect intellectual property and proprietary rights.</p><br />
	<p>You agree to observe and abide by all copyright and other proprietary notices, legends or other restrictions contained in any such content and will not make any changes thereto. You will not modify, publish, transmit, reverse engineer, participate in the transfer or sale, create derivative works, or in any way exploit any of the content, in whole or in part, found on the Site.</p><br />
	<p>Prthenon content is not for resale. Your use of the Site does not entitle you to make any unauthorized use of any protected content, and in particular you will not delete or alter any proprietary rights or attribution notices in any content. You will use protected content solely for your personal use, and will make no other use of the content without the express written permission of Prthenon and the copyright owner. You agree that you do not acquire any ownership rights in any protected content. We do not grant you any licenses, express or implied, to the intellectual property of Prthenon or our licensors except as expressly authorized by these Terms. </p><br />
	
	<h4><u>Use of communication services</u></h4><br />
	<p>The Site may contain bulletin board services, chat areas, news groups, forums, communities, personal web pages, calendars, and/or other message or communication facilities designed to enable you to communicate with the public at large or with a group (collectively, "Communication Services"), you agree to use the Communication Services only to post, send and receive messages and material that are proper and related to the particular Communication Service.</p><br />
	<p>By way of example, and not as a limitation, you agree that when using a Communication Service, you will not: defame, abuse, harass, stalk, threaten or otherwise violate the legal rights (such as rights of privacy and publicity) of others; publish, post, upload, distribute or disseminate any inappropriate, profane, defamatory, infringing, obscene, indecent or unlawful topic, name, material or information; upload files that contain software or other material protected by intellectual property laws (or by rights of privacy of publicity) unless you own or control the rights thereto or have received all necessary consents; upload files that contain viruses, corrupted files, or any other similar software or programs that may damage the operation of another's computer; advertise or offer to sell or buy any goods or services for any business purpose, unless such Communication Service specifically allows such messages; conduct or forward surveys, contests, pyramid schemes or chain letters; download any file posted by another user of a Communication Service that you know, or reasonably should know, cannot be legally distributed in such manner; falsify or delete any author attributions, legal or other proper notices or proprietary designations or labels of the origin or source of software or other material contained in a file that is uploaded, restrict or inhibit any other user from using and enjoying the Communication Services; violate any code of conduct or other guidelines which may be applicable for any particular Communication Service; harvest or otherwise collect information about others, including e-mail addresses, without their consent; violate any applicable laws or regulations.</p><br />
	<p>Prthenon has no obligation to monitor the Communication Services. However, Prthenon reserves the right to review materials posted to a Communication Service and to remove any materials in its sole discretion. Prthenon reserves the right to terminate your access to any or all of the Communication Services at any time without notice for any reason whatsoever.</p><br />
	<p>Prthenon reserves the right at all times to disclose any information as necessary to satisfy any applicable law, regulation, legal process or governmental request, or to edit, refuse to post or to remove any information or materials, in whole or in part, in Prthenon's sole discretion. Always use caution when giving out any personally identifying information about yourself or your children in any Communication Service. Prthenon does not control or endorse the content, messages or information found in any Communication Service and, therefore, Prthenon specifically disclaims any liability with regard to the Communication Services and any actions resulting from your participation in any Communication Service. Managers and hosts are not authorized Prthenon spokespersons, and their views do not necessarily reflect those of Prthenon.</p><br />
	<p>Materials uploaded to a Communication Service may be subject to posted limitations on usage, reproduction and/or dissemination. You are responsible for adhering to such limitations if you upload the materials.</p><br />
	<p>Materials provided to www.prthenon.com or posted on any Prthenon web page Prthenon does not claim ownership of the materials you provide to www.prthenon.com (including feedback and suggestions) or post, upload, input or submit to any Prthenon Site or our associated services (collectively "Submissions"). However, by posting, uploading, inputting, providing or submitting your Submission you are granting Prthenon, our affiliated companies and necessary sub licensees permission to use your Submission in connection with the operation of their Internet businesses including, without limitation, the rights to: copy, distribute, transmit, publicly display, publicly perform, reproduce, edit, translate and reformat your Submission; and to publish your name in connection with your Submission. No compensation will be paid with respect to the use of your Submission, as provided herein.</p><br />
	<p>Prthenon is under no obligation to post or use any Submission you may provide and may remove any Submission at any time in Prthenon's sole discretion. By posting, uploading, inputting, providing or submitting your Submission you warrant and represent that you own or otherwise control all of the rights to your Submission as described in this section including, without limitation, all the rights necessary for you to provide, post, upload, input or submit the Submissions.</p><br />
	
	<h4><u>International Users</u></h4><br />
	<p>The Service is controlled, operated and administered by Prthenon from our offices within the USA. If you access the Service from a location outside the USA, you are responsible for compliance with all local laws. You agree that you will not use the Prthenon Content accessed through www.prthenon.com in any country or in any manner prohibited by any applicable laws, restrictions or regulations.</p><br />
	
	<h4><u>Indemnification</u></h4><br />
	<p>You agree to indemnify, defend and hold harmless Prthenon, its officers, directors, employees, agents and third parties, for any losses, costs, liabilities and expenses (including reasonable attorneys' fees) relating to or arising out of your use of or inability to use the Site or services, any user postings made by you, your violation of any terms of this Agreement or your violation of any rights of a third party, or your violation of any applicable laws, rules or regulations. Prthenon reserves the right, at its own cost, to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, in which event you will fully cooperate with Prthenon in asserting any available defenses.</p><br />
	
	<h4><u>Liability disclaimer</u></h4><br />
	<p>THE INFORMATION, SOFTWARE, PRODUCTS, AND SERVICES INCLUDED IN OR AVAILABLE THROUGH THE SITE MAY INCLUDE INACCURACIES OR TYPOGRAPHICAL ERRORS. CHANGES ARE PERIODICALLY ADDED TO THE INFORMATION HEREIN. PRTHENON AND/OR ITS SUPPLIERS MAY MAKE IMPROVEMENTS AND/OR CHANGES IN THE SITE AT ANY TIME. PRTHENON AND/OR ITS SUPPLIERS MAKE NO REPRESENTATIONS ABOUT THE SUITABILITY, RELIABILITY, AVAILABILITY, TIMELINESS, AND ACCURACY OF THE INFORMATION, SOFTWARE, PRODUCTS, SERVICES AND RELATED GRAPHICS CONTAINED ON THE SITE FOR ANY PURPOSE. TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, ALL SUCH INFORMATION, SOFTWARE, PRODUCTS, SERVICES AND RELATED GRAPHICS ARE PROVIDED "AS IS" WITHOUT WARRANTY OR CONDITION OF ANY KIND. PRTHENON AND/OR ITS SUPPLIERS HEREBY DISCLAIM ALL WARRANTIES AND CONDITIONS WITH REGARD TO THIS INFORMATION, SOFTWARE, PRODUCTS, SERVICES AND RELATED GRAPHICS, INCLUDING ALL IMPLIED WARRANTIES OR CONDITIONS OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE AND</p><br />
	
	<h4><u>NON-INFRINGEMENT.</u></h4><br />
	<p>TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT SHALL PRTHENON AND/OR ITS SUPPLIERS BE LIABLE FOR ANY DIRECT, INDIRECT, PUNITIVE, INCIDENTAL, SPECIAL, CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOSS OF USE, DATA OR PROFITS, ARISING OUT OF OR IN ANY WAY CONNECTED WITH THE USE OR PERFORMANCE OF THE SITE, WITH THE DELAY OR INABILITY TO USE THE SITE OR RELATED SERVICES, THE PROVISION OF OR FAILURE TO PROVIDE SERVICES, OR FOR ANY INFORMATION, SOFTWARE, PRODUCTS, SERVICES AND RELATED GRAPHICS OBTAINED THROUGH THE SITE, OR OTHERWISE ARISING OUT OF THE USE OF THE SITE, WHETHER BASED ON CONTRACT, TORT, NEGLIGENCE, STRICT LIABILITY OR OTHERWISE, EVEN IF PRTHENON OR ANY OF ITS SUPPLIERS HAS BEEN ADVISED OF THE POSSIBILITY OF DAMAGES. BECAUSE SOME STATES/JURISDICTIONS DO NOT ALLOW THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES, THE ABOVE LIMITATION MAY NOT APPLY TO YOU. IF YOU ARE DISSATISFIED WITH ANY PORTION OF THE SITE, OR WITH ANY OF THESE TERMS OF USE, YOU’RE SOLE AND EXCLUSIVE REMEDY IS TO DISCONTINUE USING THE SITE.</p><br />
	
	<h4><u>Termination/access restriction</u></h4><br />
	<p>Prthenon reserves the right, in its sole discretion, to terminate your access to the Site and the related services or any portion thereof at any time, without notice. To the maximum extent permitted by law, this agreement is governed by the laws of the State of Ohio and you hereby consent to the exclusive jurisdiction and venue of courts in Ohio in all disputes arising out of or relating to the use of the Site. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these Terms, including, without limitation, this section. </p><br />
	<p>You agree that no joint venture, partnership, employment, or agency relationship exists between you and Prthenon as a result of this agreement or use of the Site. Prthenon's performance of this agreement is subject to existing laws and legal process, and nothing contained in this agreement is in derogation of Prthenon's right to comply with governmental, court and law enforcement requests or requirements relating to your use of the Site or information provided to or gathered by Prthenon with respect to such use. If any part of this agreement is determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth above, then the invalid or unenforceable provision will be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of the agreement shall continue in effect.</p><br />
	<p>Unless otherwise specified herein, this agreement constitutes the entire agreement between the user and Prthenon with respect to the Site and it supersedes all prior or contemporaneous communications and proposals, whether electronic, oral or written, between the user and Prthenon with respect to the Site. A printed version of this agreement and of any notice given in electronic form shall be admissible in judicial or administrative proceedings based upon or relating to this agreement to the same extent an d subject to the same conditions as other business documents and records originally generated and maintained in printed form. It is the express wish to the parties that this agreement and all related documents be written in English.</p><br />
	
	<h4><u>Changes to Terms</u></h4><br />
	<p>Prthenon reserves the right, in its sole discretion, to change the Terms under which www.prthenon.com is offered. The most current version of the Terms will supersede all previous versions. Prthenon encourages you to periodically review the Terms to stay informed of our updates.</p><br>
	
	<h4><u>Contact Us</u></h4><br />
	<p>Prthenon welcomes your questions or comments regarding the Terms:</p><br><br />
	<p align="right">Sincerely,<br />Prthenon</p>
	
	
	
	
	</div>
  </div>
  
  <br clear="all" />
  <div class="clr"></div>

<div style="margin-top:10px;">
<?php
	include('footer.php');
?>
</div>
</body>
</html>