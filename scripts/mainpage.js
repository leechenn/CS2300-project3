var click = 0;
// the regular expression for tag
var reg=/^[-' $*&a-zA-Z\d]{1,30}$/;
var tagSet = new Set();
var hasTag = true;
var count=1;
window.onload = function(){
  var foot=document.getElementsByClassName("social-circle");
  var a=foot[0].getElementsByTagName("a");

  for(var j=0; j<a.length; j++){
    a[j].onmouseover=function(){
      var id=this.id;
      this.classList.add(id);
    };
    a[j].onmouseout = function(){
      var id=this.id;
      this.classList.remove(id);
    };
  }
  if(document.getElementById("imageViewBox")){
    var imageViewBoxHeight = document.getElementById("imageViewBox").offsetHeight;
    var imageshowImageHeight = document.getElementById("showImage").offsetHeight;
    if(imageshowImageHeight<imageViewBoxHeight){
      if(document.getElementById("leftArrow")){
        document.getElementById("leftArrow").style.height = imageshowImageHeight+"px";
      }
      if(document.getElementById("rightArrow")){
        document.getElementById("rightArrow").style.height = imageshowImageHeight+"px";
      }
    }
    document.getElementById("imageViewBox").onscroll = function(){
      if(document.getElementById("leftArrow")){
        document.getElementById("leftArrow").style.top = document.getElementById("imageViewBox").scrollTop+"px";
      }
      if(document.getElementById("rightArrow")){
        document.getElementById("rightArrow").style.top = document.getElementById("imageViewBox").scrollTop+"px";
      }
    }

  }

  if(document.getElementById("manageTags")){
    var tagList = document.getElementById("manageTags").getElementsByTagName("ul");
    var tagInput = document.getElementById("tagInput");
    var tagsForm = document.getElementById("tagsForm");
    var hiddenInputArray = tagsForm.getElementsByClassName("hiddentagName");
    for(var i=0; i<hiddenInputArray.length; i++){
      tagSet.add((hiddenInputArray[i].value).toLowerCase());
    }

    tagInput.onkeydown = function(event){
      var tagsForm = document.getElementById("tagsForm");
      if(event.keyCode == "13"){
        var newTag = tagInput.value.trim();
        hasTag = tagSet.has(newTag.toLowerCase());
        if(!hasTag && reg.test(newTag)){
          tagList[0].innerHTML+=("<li class='canDelete'><i class='fa fa-tag'></i><span>"+newTag+"</span><span class='deleteTag' onclick='deleteTag(this)'>&times;</span></li>");
          tagsForm.innerHTML+=("<input type='hidden' value='' name='tags[]'/>");
          var currentinput = tagsForm.getElementsByTagName("input");
          currentinput[currentinput.length-1].value = newTag;
          tagSet.add(newTag.toLowerCase());
        }
        tagInput.value = "";
      }
      if(event.keyCode == "8" && tagInput.value=="" && document.getElementsByClassName('canDelete').length!=0){
        var canDeleteTag = document.getElementsByClassName('canDelete');
        if(count==2){
          var tagValue = canDeleteTag[canDeleteTag.length-1].getElementsByTagName("span")[0].innerText.toLowerCase();
          tagSet.delete(tagValue);
          canDeleteTag[canDeleteTag.length-1].parentNode.removeChild(canDeleteTag[canDeleteTag.length-1]);
          var tagsForm = document.getElementById("tagsForm");
          var hiddenInputArray = tagsForm.getElementsByTagName("input");
          hiddenInputArray[hiddenInputArray.length-1].parentNode.removeChild(hiddenInputArray[hiddenInputArray.length-1]);
          count = 1;
        }
        else{
          canDeleteTag[canDeleteTag.length-1].style.opacity = 0.5;
          count+=1;
        }


      }


    }
  }


}

function deleteTag(object){
  var tagsForm = document.getElementById("tagsForm");
  var hiddenInputArray = tagsForm.getElementsByTagName("input");
  object.parentNode.parentNode.removeChild(object.parentNode);
  var tagValue = object.parentNode.getElementsByTagName("span")[0].innerText;
  tagSet.delete(tagValue);
  for(var i=0; i<hiddenInputArray.length; i++){
    if(hiddenInputArray[i].value==tagValue){
      hiddenInputArray[i].parentNode.removeChild(hiddenInputArray[i]);
    }
  }
}



function openModal() {
  document.getElementById('myModal').style.display = "block";
  var hint = document.getElementById('imageChosenHint');
  hint.style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
  var output = document.getElementById('output');
  output.src = "";
  document.getElementById('uploadFile').reset();

}
function closePhotoView() {
  document.getElementById('myModal-photoview').style.display = "none";

}
function showTags(){
  if(click==0){
    document.getElementsByClassName('tagsContainer')[0].classList.remove('active');
    click=1;
  }
  else{

    document.getElementsByClassName('tagsContainer')[0].classList.add("active");
    click=0;
  }
}

var loadFile = function(event) {
  var output = document.getElementById('output');
  var hint = document.getElementById('imageChosenHint');
  if(event.target.files[0]){
    hint.style.display = "none";
    output.src = URL.createObjectURL(event.target.files[0]);
  }
  else{
    output.src = "";
    hint.style.display = "block";
  }

};

var clearForm = function(){
  var output = document.getElementById('output');
  output.src = "";
  var hint = document.getElementById('imageChosenHint');
  hint.style.display = "block";
}

var delete_sure = function(){
  return confirm("Are you sure to delete this photo?");
}

var submit_sure = function(){
  return confirm("Are you sure to upload this photo?");
}
