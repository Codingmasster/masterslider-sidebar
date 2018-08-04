## MasterSlider-Sidebar
MasterSlider-sidebar is add-on to MasterSlider and its functionality is to display some custom 
content with each slide in slider at your required page and place, whenever the slide changes 
the content of the page or div automatically changes accordingly. 

### Prerequisites

1. Master Slider

## Installing

* After wordpress installation proceed to the plugins sections and search for __"MasterSlider"__. if not exists then please install it.
* Extract the **masterslider-sidebar** into the local directory of wordpress */wp-content/plugins/*. 
* Activate both plugins from the admin panel of wordpress.
* After Successful installation, proceed to *Master Slider* tab in wordpress dashboard a new tab named __MasterSlider__ will appear. 
* Create a new slider.
* You can choose any sample slider or make a new custom one.
    1. From __SliderCallbacks__ tab you are required to add a little functionality on ___On slide change start___ by clicking + button next to the list.
	```
	function(event){
		 var api = event.target;
		 display_sidebar_content(api.index());
	}
	```  
    2. Click on __Save Changes__ and slider with your required setting has been created.

## Usage

* To use the _masterslider_ and _masterSlider_sidebar_ we will use the shortcode on the page where we want the slider and content to be placed.
* Move to the page where you want to display the slider.
    * For MasterSlider_sidebar add shortcode ``` [masterslider_sidebar slider_id="value"]  ``` __value = ID__
    * Save the page and publish it.
* Preview the page to check your required results.