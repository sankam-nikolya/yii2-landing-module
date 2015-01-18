function runLanding(incSettings) {
    
    var settings = incSettings;
    
//    alert(settings.imageDelete);
//    return;

    // Define classes
    var areaBlockClass = 'area-block';
    var class_prefix = "col-md-";
    var editorId = "block-content-editor";
    var editorName = "block-text";
    var applyLinkClass = "land-apply-block";
    var editLinkClass = "land-edit-block";
    
    // Define selectors
    $drawArea = $("#land-draw-area");
    $sizeSelectBt = $("#size-select-bt");
    $addBlockBt = $("#land-add-block-bt");
    $delBlockBt = $("#land-del-block-bt");
    
    
    /* Define actions */
    // Click on size selector
    $("#size-select-menu li a").click(function() {
        var size_value = $(this).text();
        
        $("#size-select-bt > span.size-select-bt-text").text(size_value);
                        
        $("#size-select-bt").val(size_value.match(/\d+$/g)[0]);
    });                
    
    // Click onto addBlock button
    $addBlockBt.click(landAddBlock);    
    
    // Click onto Block in Area
    $drawArea.on('click', '.'+areaBlockClass, function() {
        $(this).closest("div.row").makeRowActive();
        $(this).makeCellActive();
    });
    
    // Define click on Close button
    $drawArea.on('click', ".close-land-block > button.close", deleteAreaBlock);
    
    // Define click on Edit button
    $drawArea.on('click', "a."+editLinkClass, appendContentEditor);
    
    // Define click on Apply button
    $drawArea.on('click', "a."+applyLinkClass, applyEditorText);
       
    /* End Define actions */

    // Define functions to activate Rows and Cells
    $.fn.extend({
        makeRowActive: function() {
            deactivateRows();
            return this.addClass("land-active-row");
        },
        makeCellActive: function() {
            deactivateCells();            
            return this.addClass("active-area-block"); 
        }
    });        
    
    // Add block to Draw Area Function
    function landAddBlock() {        
        
        // Read selected size value
        var size_value = $sizeSelectBt.val();

        // Check it on existence
        if(size_value == '') {
            alert("Выберите размер");
            return false;
        }
            
        // Form CSS class name for Bootstrap
        var class_name = class_prefix + size_value;
        var areaBlockString = 
                "<div class='" + class_name + "' data-remove='1'>"
                    + "<div class='" + areaBlockClass + "'>" 
                        + "<div class='row header'>"
                            + "<div class='col-md-12'>"
                                + "<div class='headerWrap'>"
                                    + '<span class="close-land-block"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></span>'
                                    + '<a href="#" class="'+editLinkClass+'"><i class="glyphicon glyphicon-pencil"></i></a>'
                                    + '<a href="#" class="'+applyLinkClass+'" style="display: none;"><i class="glyphicon glyphicon-ok"></i></a>'
                                + "</div>"
                            + "</div>"
                        + "</div>"  
                        + "<div class='row content'>"
                            + "<div class='col-md-12'>"
                                + "<div class='content-wrap'></div>"
                            + "</div>"
                        + "</div>"
                    + "</div>"
                + "</div>";

        // Checking rows on existence
        if($drawArea.children("div.row").length == 0)            
            // If there is nothing, we append one and make it active
            $("<div class='row land-active-row'></div>").appendTo($drawArea).makeRowActive();
        
        // Checking rows with class "active" on existence
        if($drawArea.children("div.land-active-row").length == 0) {
            alert("Выберите строку для добавления блока");
            return false;
        }

        var rowWidth = parseInt(size_value);
        // Checking row width on overflow
        $drawArea.find("div.land-active-row").children("div[class^='"+class_prefix+"']").each(function() {
            rowWidth += parseInt(this.className.match(/\d+/)[0], 10);
        });
        if(rowWidth > 12) {
            $("<div class='row'></div>")
                    .insertAfter("div.land-active-row")
                    .makeRowActive()
                    .append(areaBlockString)
                    .find("div."+areaBlockClass)
                    .makeCellActive();
//            console.log('New row appended');
        } else {                                                 
            $(areaBlockString).appendTo($drawArea.children("div.land-active-row"))
                .find("div."+areaBlockClass)
                .makeCellActive();            
        }  
        
//        console.log('End');
    }
    
    // Find and delete all active rows
    function deactivateRows() {
        $drawArea.children("div.land-active-row").each(function(index, element) {                
            $(element).removeClass("land-active-row");
        });
    }
    
    // Find and delete all active cells
    function deactivateCells() {
        $drawArea.find("div.active-area-block").each(function(index, element) {                
            $(element).removeClass("active-area-block");
        });
    }               
    
    // Function of deleting area block
    function deleteAreaBlock() {
        
        if(checkIfRedactorExists())
            return false;
        
        if($(this).closest("div."+areaBlockClass).parent("div").attr("data-remove") == 0)
           return false;              
        
        $(this).closest("div."+areaBlockClass).find('div.content-wrap img').each(function(index, element) {
            deleteImage(element);
        });        
        
        if($(this).closest("div."+areaBlockClass).closest("div.row").children().length == 1) {
            $(this).closest("div."+areaBlockClass).closest("div.row").remove();
        } else {
            $(this).closest("div."+areaBlockClass).parent("div").remove();
        }                
    }
    
    // Append content into area block
    function appendContentEditor() {                    
                
        if(checkIfRedactorExists())
            return false;
                
        var textArea = "<textarea id='" + editorId + "' name='" + editorName + "' style='display:none;'></textarea>";
        
        if($(this).closest("div.header").siblings("div.content").length == 0) {
            // append text area
            $(this).closest("div.header").next("div.content").find("div.content-wrap").html(textArea);
            
            // wysiwyg text editor init
            initRedactor();
        } else {
            // read user content
            var userContent = $(this).closest("div.header").next("div.content").find("div.content-wrap").html();
            
            console.log("appendEditor: " + userContent);
            
            // append textarea
            $(this).closest("div.header").next("div.content").find("div.content-wrap").html(textArea);
            
            // wysiwyg text editor init
            initRedactor();
            
            // append user content to editor
            if(userContent != '') {
                $("textarea#"+editorId).redactor('insert.html', userContent, false);
            }
        }                
        $(this).siblings("."+applyLinkClass).show();
        $(this).hide();                                                
    }
    
    function checkIfRedactorExists() {
        // Check if editor exists on page, we blink the block on which editor is placed
        $editorOnPage = $drawArea.find("#"+editorId);
        if($editorOnPage.length > 0) {                
                $editorOnPage.closest("div."+areaBlockClass).animate({opacity: 0.25}, 400);
                $editorOnPage.closest("div."+areaBlockClass).animate({opacity: 1}, 400);
                return true;
        } else {
            return false;
        }
    }
    
    // Function applies changes into content part in area block
    function applyEditorText() {
                
        $(this).siblings(".land-edit-block").show();
        $(this).hide();
        
        var userContent = $("textarea#"+editorId).redactor('code.get');                
                        
        $(this).closest("div.header").next("div.content").find("div.content-wrap").html(userContent);                
        
        console.log("applyEditor: " + userContent);
        
        clearTemp();
    }
    
    // Function cleans temporary tags
    function clearTemp() {
        $("span.redactor-toolbar-tooltip").remove();
    }
    
    // Function deletes tags and files of images
    function deleteImage(image) {
        
        if(image == '')
            return false;
        
        var name = $(image).attr('data-name');

        $.ajax({
            url: settings.imageDelete,
            type: 'post',
            data: 'filename=' + name
        });
    }
        
    // Function initializes wysiwyg-editor
    function initRedactor() {
        // Call the imperavi editor
        $("textarea#"+editorId).redactor({
            focus: true,
            cleanOnPaste: false,
            removeDataAttr: false,
            allowedTags: ['p', 'img', 'h1', 'h2'],
            allowedAttr: [
                ['img', ['src','style','data-name']],
                ['p', ['style']],
            ],
            imageUpload: settings.imageUpload,
            imageManagerJson: settings.listImagesAction,
            imageDeleteCallback: function(url, image)
            {       
                deleteImage(image);                
            },
            imageUploadCallback: function(image, json)
            {                
                $(image).attr('data-name', json.filename);
            },                        
            plugins: ['imagemanager']
        });
    }
}