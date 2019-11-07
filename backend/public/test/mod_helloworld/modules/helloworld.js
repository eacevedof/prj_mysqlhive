//helloworld.js
class Helloworld extends HTMLElement{

  constructor(text) {
    console.log("Helloworld.constructor")
    super()
    this.init(text)
  }

  init(text){
    // Create a shadow root
    //alert("init")
    var shadow = this.attachShadow({mode: 'open'});

    // Create spans
    var wrapper = document.createElement('span');
    wrapper.setAttribute('class','wrapper');
    var icon = document.createElement('span');
    icon.setAttribute('class','icon');
    icon.setAttribute('tabindex', 0);
    var info = document.createElement('span');
    info.setAttribute('class','info');

    // Take attribute content and put it inside the info span
    var text = this.getAttribute('text');
    info.textContent = text;

    // Insert icon
    var imgUrl;
    if(this.hasAttribute('img')) {
      imgUrl = this.getAttribute('img');
    } else {
      //imgUrl = 'img/default.png';
      imgUrl = "https://www.flaticon.com/premium-icon/icons/svg/1055/1055189.svg"
    }
    var img = document.createElement('img');
    img.src = imgUrl;
    icon.appendChild(img);

    // Create some CSS to apply to the shadow dom
    var style = document.createElement('style');

    style.textContent = `
    .wrapper {
      position: relative;
    }
    .info {
      font-size: 0.8rem;
      width: 200px;
      display: inline-block;
      border: 1px solid black;
      padding: 10px;
      background: white;
      border-radius: 10px;
      opacity: 0;
      transition: 0.6s all;
      position: absolute;
      bottom: 20px;
      left: 10px;
      z-index: 3;
    }
    img {
      width: 1.2rem;
    }
    .icon:hover + .info, .icon:focus + .info {
      opacity: 1;
    }
    `;

    // attach the created elements to the shadow dom
    shadow.appendChild(style);
    shadow.appendChild(wrapper);
    wrapper.appendChild(icon);
    wrapper.appendChild(info);    
  }//init

}// Helloworld

customElements.define('hello-world', Helloworld)
export { Helloworld }