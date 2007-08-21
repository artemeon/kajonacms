//   (c) 2004-2006 by MulchProductions, www.mulchprod.de
//   (c) 2007 by Kajona, www.kajona.de
//       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt
//       $Id: kajona.js 1631 2007-07-21 12:42:52Z sidler $

/**
 * 
 * This file includes a script to be used to make lists drag n dropable.
 * The array arrayListIds is parsed, all li-elements are added
 * See the YUI dragdrop-list-example for further infos
 */

if(arrayListIds == null)
	var arrayListIds = new Array();


(function() {
	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;
	var DDM = YAHOO.util.DragDropMgr;

	//create namespaces
	var kajona = { };
	kajona.dragndroplist = {};
	//Basic functions
	kajona.dragndroplist.DDApp = {
    	init: function() {
		   //iterate over all lists available
		   for(l=0; l<arrayListIds.length; l++) {
		   	   listId = arrayListIds[l];
	           //basic dnd list				
	           new YAHOO.util.DDTarget(listId);
			   //load items in list
			   var arrayListItems = YAHOO.util.Dom.getChildren(listId);
			   for(i=0;i<arrayListItems.length;i=i+1) {
			   		Dom.setStyle(arrayListItems[i], "cursor", "move");
		 			new kajona.dragndroplist.DDList(arrayListItems[i].id);
		   	   }
		   }
    	},
	    getCurrentPos : function(idOfRow) {
		   for(l=0; l<arrayListIds.length; l++) {
		   	   listId = arrayListIds[l];	
		       var arrayListItems = YAHOO.util.Dom.getChildren(listId);
			   for(i=0;i<arrayListItems.length;i=i+1) {
			 		if(arrayListItems[i].id == idOfRow) {
			 			return i+1;
			 		}  
			   }
		   }
	    },
		
		getCurrentList : function(idOfRow) {
		   for(l=0; l<arrayListIds.length; l++) {
		   	   listId = arrayListIds[l];	
		       var arrayListItems = YAHOO.util.Dom.getChildren(listId);
			   for(i=0;i<arrayListItems.length;i=i+1) {
			 		if(arrayListItems[i].id == idOfRow) {
			 			return listId;
			 		}  
			   }
		   }
	    }
	};

	kajona.dragndroplist.DDList = function(id, sGroup, config) {
	    kajona.dragndroplist.DDList.superclass.constructor.call(this, id, sGroup, config);
	    var el = this.getDragEl();
	    Dom.setStyle(el, "opacity", 0.67); // The proxy is slightly transparent
	    this.goingUp = false;
	    this.lastY = 0;
	};

	YAHOO.extend(kajona.dragndroplist.DDList, YAHOO.util.DDProxy, {
	
	    startDrag: function(x, y) {
	        // make the proxy look like the source element
	        var dragEl = this.getDragEl();
	        var clickEl = this.getEl();
	        Dom.setStyle(clickEl, "visibility", "hidden");
	        dragEl.innerHTML = clickEl.innerHTML;
	    },
	
	    endDrag: function(e) {
	        var srcEl = this.getEl();
	        var proxy = this.getDragEl();
	        // Show the proxy element and animate it to the src element's location
	        Dom.setStyle(proxy, "visibility", "");
	        var a = new YAHOO.util.Motion( 
	            proxy, { 
	                points: { 
	                    to: Dom.getXY(srcEl)
	                }
	            }, 
	            0.2, 
	            YAHOO.util.Easing.easeOut 
	        )
	        var proxyid = proxy.id;
	        var thisid = this.id;
	        // Hide the proxy and show the source element when finished with the animation
	        a.onComplete.subscribe(function() {
	                Dom.setStyle(proxyid, "visibility", "hidden");
	                Dom.setStyle(thisid, "visibility", "");
	            });
	        a.animate();
	        //save new pos to backend
	        kajonaAdminAjax.setAbsolutePosition(this.id, kajona.dragndroplist.DDApp.getCurrentPos(this.id), kajona.dragndroplist.DDApp.getCurrentList(this.id));
	    },
	
	    onDragDrop: function(e, id) {
	        if (DDM.interactionInfo.drop.length === 1) {
	            var pt = DDM.interactionInfo.point; 
	            var region = DDM.interactionInfo.sourceRegion; 
	            if (!region.intersect(pt)) {
	                var destEl = Dom.get(id);
	                var destDD = DDM.getDDById(id);
	                destEl.appendChild(this.getEl());
	                destDD.isEmpty = false;
	                DDM.refreshCache();
	            }
	        }
	    },
	
	    onDrag: function(e) {
	        var y = Event.getPageY(e);
	        if (y < this.lastY) {
	            this.goingUp = true;
	        } else if (y > this.lastY) {
	            this.goingUp = false;
	        }
	        this.lastY = y;
	    },
	
	    onDragOver: function(e, id) {
	        var srcEl = this.getEl();
	        var destEl = Dom.get(id);
	        // We are only concerned with list items, we ignore the dragover notifications for the list.
	        if (destEl.nodeName.toLowerCase() == "li") {
	            var orig_p = srcEl.parentNode;
	            var p = destEl.parentNode;
	            if (this.goingUp) {
	                p.insertBefore(srcEl, destEl); // insert above
	            } else {
	                p.insertBefore(srcEl, destEl.nextSibling); // insert below
	            }
	            DDM.refreshCache();
	        }
	    }
	});

	Event.onDOMReady(kajona.dragndroplist.DDApp.init, kajona.dragndroplist.DDApp, true);
})();