<?php
/* @var $this SiteController */

$this -> pageTitle = Yii::app() -> name . ' - FAQ';
?>
<h3>Frequently asked questions</h3>

<a href="#usage">1. How do I use this?</a><br/>
<a href="#token">2. How do I generate a token?</a><br/>
<a href="#nxt">3. What is NXT and where can I get it?</a><br/>
<a href="#special">4. Whats so special about this?</a><br/>
<a href="#opensource">5. Is this project open source?</a><br/>
<a href="#nxtmemo">6. Where can I find out more about NXTMemo?</a><br/>

<hr/>
<h4><a name="usage">How do I use this?</a></h4>
<p>Use the messaging feature in your NXT client and send a message to <b><?php echo Yii::app() -> params['nxt_account']; ?></b>.</p>
<p>Words starting with a hastag (#) link to a search query.</p>
<p>Words starting with an at-sign (@) link to an alias.</p>
<p>Please note messages need to be sent <strong>unencrypted</strong>.</p>
<img src="<?php echo $this -> createURL('/'); ?>/images/encryptmessage.png" />
<hr/>
<h4><a name="token">How do I generate a token?</a></h4>
<p>A NXT token is required to login.</p>
<img src="<?php echo $this -> createURL('/'); ?>/images/tokenmenu.png" /><br/>
<img src="<?php echo $this -> createURL('/'); ?>/images/generatetoken.png" />
<hr/>
<h4><a name="nxt">What is NXT and where can I get it?</a></h4>
<p>NXT is a second generation cryptocurrency. It is basically like Bitcoin but much more advanced!</p>
<p>Go to <a href="http://nxt.org">http://nxt.org</a> for more information or to download the latest client software.</p>
<p>You can get some free NXT from <a href="http://nxtra.org/faucet/">http://nxtra.org/faucet/</a>.</p>
<p>Visit <a href="https://nxtforum.org">https://nxtforum.org</a> if you have any questions.</p>
<hr/>
<h4><a name="special">Whats so special about this?</a></h4>
<p>The messages you see on NXTMemo are permanently stored on the NXT blockchain.</p>
<p>The blockchain is a database maintained by a network of countless nodes (computers) verifying each others contents, so your messages cannot be censored or retroactively edited - not by us or even yourself.</p>
<hr/>
<h4><a name="opensource">Is this project open source?</a></h4>
<p>Yes! You can find the source code at <a href="https://github.com/nxtmemo/nxtmemo">https://github.com/nxtmemo/nxtmemo</a></p>
<hr/>
<h4><a name="nxtmemo">Where can I find out more about NXTMemo?</a></h4>
<p>Contact <code>mail@nxtmemo.com</code>.</p>
<p>Thread on nxtforum.org: <a href="https://nxtforum.org/general-discussion/nxtmemo-twitter-clone-based-on-nxt-messaging-system/">https://nxtforum.org/general-discussion/nxtmemo-twitter-clone-based-on-nxt-messaging-system/</a></p>
