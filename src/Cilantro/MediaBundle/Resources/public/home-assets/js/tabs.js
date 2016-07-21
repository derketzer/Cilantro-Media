// faq Tabs 



 // Collapse For FAQ Page
	 $(function(){
		 jQuery(".collapsible").collapsible({
			defaultOpen: "#nav-section1, #nav-section6 ,nav-section10, #nav-section20",
		 });
	 });
	 
	 

 //Vertical Tab
	 $('#parentVerticalTab').easyResponsiveTabs({
		  type: 'vertical', //Types: default, vertical, accordion
		  width: 'auto', //auto or any width like 600px
		  fit: true, // 100% fit in a container
		  closed: 'accordion', // Start closed if in accordion view
		  tabidentify: 'hor_1', // The tab groups identifier
		  activate: function(event) { // Callback function if tab is switched
				var $tab = $(this);
				var $info = $('#nested-tabInfo2');
				var $name = $('span', $info);
				$name.text($tab.text());
				$info.show();
		  }
	 });



