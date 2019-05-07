var asset_id = 0;

    $(document).ready( function(){
      document.querySelectorAll(".assets .asset").forEach( e => e.addEventListener("dragstart", function(ev){
        ev.dataTransfer.setData("text", this.innerHTML.trim());
        ev.dataTransfer.setData("data-id", this.getAttribute("data-id"));
      }))

      document.querySelector('.draw-pane').addEventListener("dragover", function(ev){
        ev.preventDefault();
      })

      document.querySelector('.draw-pane').addEventListener("drop", function(ev){
        ev.preventDefault();
        if( ev.dataTransfer.getData("action") == "move"){
          let top = ev.layerY;
          let left = ev.layerX;
          if( !ev.target.classList.contains('background-img') ){
            if( ev.target.closest(".asset") ){
              let top_off = parseFloat(ev.target.closest(".asset").style.top);
              let left_off = parseFloat(ev.target.closest(".asset").style.left);
              top += top_off;
              left += left_off;
            }
            else if( ev.target.classList.contains("asset") ){
              let top_off = parseFloat(ev.target.style.top);
              let left_off = parseFloat(ev.target.style.left);
              top += top_off;
              left += left_off; 
            }
          }
          let id = ev.dataTransfer.getData("id");
          document.querySelector("#" + id).style.top = ( top - 37.5 ) + "px";
          document.querySelector("#" + id).style.left = ( left - 37.5 ) + "px";
        }
        else{
          let top = ev.layerY;
          let left = ev.layerX;
          let count = this.childNodes.length;
          var data = ev.dataTransfer.getData("text");
          var new_asset = document.createElement("div");
          new_asset.classList.add("asset");
          new_asset.innerHTML = data;
          new_asset.style.left = left + "px";
          new_asset.style.top = top + "px";
          new_asset.style["z-index"] = count;
          new_asset.setAttribute("draggable", true);
          new_asset.addEventListener("dragstart", move );
          new_asset.setAttribute("id", "asset_"+asset_id);
          new_asset.setAttribute("data-id", ev.dataTransfer.getData("data-id") )
          asset_id++;
          this.insertBefore(new_asset, this.childNodes[0]); 
        }
        
      })

      function move( ev ){
        ev.dataTransfer.setData("action", "move");
        ev.dataTransfer.setData("id", this.getAttribute("id"));
      }

      $("#background").change(function(){
        let bg = $(this).val();
        $(".draw-pane .background-img").attr("src", bg);
      })

      $(".draw-pane").on("click", ".asset", function(){
        var data_id = $(this).attr("data-id");
        var fields_str = $(".asset-cover .asset[data-id=" + data_id + "] + input[type=hidden]").val();
        replaceDialog(fields_str);
        $(".dialog").addClass("open");
      })

      $(".dialog .close").click(function(){
        $(this).closest(".dialog").removeClass("open");
      })

      $(".dialog .cancel").click(function(){
        $(this).closest(".dialog").removeClass("open");
      })

      function replaceDialog(fields_str) {
        $(".dialog-content").html("")
        var fields = fields_str.split(",")
        for( let i = 0 ; i < fields.length ; i++ ){
          var field = fields[i].trim()
          var html = `
            <div class="form">
              <label>` + field + `</label>
              <input class="field input-form" name="` + field + `">
            </div>
          `
          var form = $(html);
          $(".dialog-content").append(form);
        }
      }  

    } );