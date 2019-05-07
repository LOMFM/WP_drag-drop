var fileDom = document.querySelector(".image-selector");
var baseurl = "/wp-admin/admin-ajax.php"

if( fileDom ){
	fileDom.addEventListener("click", function(event){
		this.querySelector("input[type='file']").click();
	})

	fileDom.querySelector("input[type='file']").addEventListener("change", function(event){
		let file = this.files[0];
		let reader = new FileReader();
		reader.onload = (e) => {
    		// The file's text will be printed here
    		fileDom.querySelector("img").setAttribute("src", e.target.result)
    		fileDom.querySelector("img").classList.add("active")
  		};
  		reader.readAsDataURL(file);
	})
}

var xhr = new XMLHttpRequest()

function remove( event ){
	var id = event.target.closest(".image").getAttribute("data-id")
	var path = event.target.closest(".image").getAttribute("data-path")
	var param = {
		action: "dd_bg_remove",
		submit: "submit",
		id: id,
		path: path
	}
	var query = Json2Query(param)
		xhr.open("GET", baseurl + "?" + query);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onload = function(){
			if( this.status == 200 ){
				var imgDom = event.target.closest(".image")
				imgDom.parentNode.removeChild(imgDom)
			}
		}
		xhr.send();
}

function Json2Query(obj){
	var items = []
	for( key in obj ){
		items.push(key + "=" + obj[key])
	}
	var result = items.join("&")
	return result;
}

var addButton = document.querySelector(".add-field");
var removeButton = document.querySelector(".remove-field");
if( addButton ){
	addButton.addEventListener("click", insertField)
	removeButton.addEventListener("click", removeField)
	function insertField(ev) {
		ev.preventDefault();
		var field_html = '<div class="table-field"><input type="text" name="table[]"><button class="remove-field">Remove</button><button class="add-field">Add field</button></div>';
		var proxy_dom = document.createElement("div");
		proxy_dom.innerHTML = field_html;
		var removeButton = proxy_dom.querySelector(".remove-field");		
		var addButton = proxy_dom.querySelector(".add-field");
		// document.querySelector(".table-fields").append(proxy_dom.querySelector(".table-field"));
		// document.querySelector(".table-fields").inserAfter
		insertAfter(proxy_dom.querySelector(".table-field"), ev.target.closest(".table-field") );
		removeButton.addEventListener("click", removeField );
		addButton.addEventListener("click", insertField);
	}

	function removeField(e) {
		e.preventDefault()
		if( document.querySelectorAll(".table-field").length > 1 ){
			var field = e.target.closest(".table-field");
			field.parentNode.removeChild(field);	
		}
	}
}

function removeElement( event ){
	var id = event.target.closest(".element").getAttribute("data-id")
	var param = {
		action: "dd_element_remove",
		submit: "submit",
		id: id
	}
	var query = Json2Query(param)
		xhr.open("GET", baseurl + "?" + query);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onload = function(){
			if( this.status == 200 ){
				var elementDom = event.target.closest(".element")
				elementDom.parentNode.removeChild(elementDom)
			}
		}
		xhr.send();
}

function insertAfter(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}