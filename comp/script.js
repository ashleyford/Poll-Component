SproutNamespace.Component.extend({
    construct: function(paramOwnerSprout, paramComponentObject)
    {
        console.log("jsonPoll.construct()");
        this._super.Component.construct.call(this, paramOwnerSprout, paramComponentObject);
		this.div = document.createElement('div');
		this.div.style.width = this.getProperty("width"); 
		this.div.style.height = this.getProperty("height");
		this.div.style.fontFamily = "Helvetica Neue,Helvetica,Arial,sans-serif";
		this.div.style.fontSize = "10pt";
		console.log(this);
    },
    initialize: function()
    {
        console.log("jsonPoll.initialize()");
        var element = this;
        element._super.Component.initialize.call(this);
		
		
		// Include jQuery library
        var script = document.createElement("script");
        script.setAttribute("type", "text/javascript");
		script.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";
		var element = this;
		script.onload = function() {
			element.$j = jQuery.noConflict();
			element.loadTrends();
		}; 
		(document.getElementsByTagName("body"))[0].appendChild(script);
        element.display.html.append(element.div);
		
		
	     // include a style sheet
		var StyleSheet = document.createElement("link");
        StyleSheet.setAttribute("type", "text/css");
		StyleSheet.setAttribute("rel", "stylesheet");
		StyleSheet.setAttribute("href", "http://papermashup.com/sproutComponents/poll/comp/barstyle.css");
		(document.getElementsByTagName("head"))[0].appendChild(StyleSheet);
		
    },
    activate: function()
    {
        console.log("jsonPoll.activate()");
        this._super.Component.activate.call(this);
    },
    deactivate: function()
    {
        console.log("jsonPoll.deactivate()");
        this._super.Component.deactivate.call(this);
    },
    getProperty: function(property)
    {
        switch (property) {
        //case "trendType":
        //   return this.getProperty("trendType");
        default:
            return this._super.Component.getProperty.call(this, property);
        }
    },
    loadTrends : function() 
    {
        //console.log("jsonPoll.loadTrends()");
		
		
		//Convert decimal to Hex string
		function decimalToHexString(number){
    		return number.toString(16).toUpperCase();
		}
		
    	var element = this,
		pollview = element.getProperty("pollview"),
		pollforvotes = element.getProperty("pollforvotes");
		barColor = decimalToHexString(parseInt(element.getProperty("barColor")));
		textColor = decimalToHexString(parseInt(element.getProperty("textColor")));
		
		element.$j('<ul id="content"></ul>').appendTo(element.div);
	
		function getPoll(){
	
			//element.$j('#content').append('Updating Results...');
	
			element.$j.getJSON('http://papermashup.com/sproutComponents/poll/get_poll.php?pollid='+element.getProperty("pollid")+'&type=getpoll&callback=?', function (data) {
		
			//console.log(data);
			
			//clear data
			element.$j('#content').html(' ');
			
			// set global var pollid
			//pollid = data[0].pollid;
			
			element.$j("#content").prepend('<strong>Q '+data[0].pollquestion+'</strong><br/><br/>');		
			var total = 0;
			element.$j.each(data[1], function (i, item) {
			total = parseInt(total)+parseInt(item.value);
			 });
			
			element.$j.each(data[1], function (i, item) {
  
  			// calculate the percentage
			if( total!=0 ){	
			var percent = Math.round(parseInt(item.value) / total * 100);
			}else{
			var percent = 0;	
			}
			
			 // if pollview is voting
			if(pollview=='0'){	
			element.$j('<li style="padding:3px;">'+ item.name +' <input type="button" id="'+item.id+'" value="vote" class="btn poll_vote" style="float:right;"/></li>').appendTo('#content');	
			}		 
			 
			// if pollview is results
			if(pollview=='1'){
			element.$j('<li><a href="#" style="color:#'+textColor+';">'+ percent +'% '+ item.name +'</a><span class="count">'+item.value+'</span><span class="index" style="width: '+percent+'%; background-color:#'+barColor+';">('+percent+'%)</span></li>').appendTo('#content');
			}
			 
        	});
		
			// element.$j("#total span").html('Total number of votes '+total+'');
  
			});
		
		
		};
	
	getPoll();
	
	if(pollforvotes=='1'){	
		setInterval(function() {
   	    getPoll();
		}, 2500);
		}
	
	
	
	// update the poll
	element.$j('.poll_vote').live("click", function(){

		console.log();
		//console.log(pollid);
		
		var updateid = element.$j(this).attr('id');
		//pollid = element.$j(this).attr('rel');
		
		 element.$j.getJSON('http://papermashup.com/sproutComponents/poll/get_poll.php?pollid='+element.getProperty("pollid")+'&updateid='+updateid+'&type=updatepoll&callback=?', function (data) {
		
			if(data.status=='1'){
				
				//alert('Poll Updated!');
				
				getPoll(pollid);		
				}
		
		
		//console.log(data);
		
			});
		
		
	});
 
    }
},
'jsonPoll');