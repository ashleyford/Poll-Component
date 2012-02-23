<?php
// Send the headers
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<component>
  <displayName>JSON Poll</displayName>
  <className>jsonPoll</className>
  <width>200</width>
  <height>250</height>
  <minimumWidth>20</minimumWidth>
  <minimumHeight>20</minimumHeight>
  <description>A Component for displaying a Poll</description>
  <properties>
  <property name="pollid" displayName="Poll Id" datatype="string" value=""/>
   <property name="pollforvotes" displayName="Display realtime votes?" datatype="enum" value="0" toolTip="">
      <enumValue displayName="No" value="0"/>
      <enumValue displayName="Yes" value="1"/>
    </property>
   <property name="pollview" displayName="Poll View" datatype="enum" value="0" toolTip="">
      <enumValue displayName="Voting" value="0"/>
      <enumValue displayName="Poll Results" value="1"/>
    </property>
  <property name="textColor" displayName="Text Color" datatype="color" value="0x000000" allowTransparency="false"/>
  <property name="barColor" displayName="Bar Color" datatype="color" value="0xAAE1FF" allowTransparency="false"/>
  <property name="question1" displayName="Question 1" datatype="string" value="This is a test"/>
  </properties>
  <version>1</version>
  <triggers>
    <trigger name="trendsLoadCompleted" displayName="Loaded" htmlSupport="true"/>
  </triggers>
<script><![CDATA[
	<?php include('script.js');?>
	]]></script>
</component>