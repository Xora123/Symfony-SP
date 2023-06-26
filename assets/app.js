/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const axios = require('axios').default;

function onClickBtnLike(event){
  event.preventDefault();

  const url = this.href;

  const spanCount=document.querySelector('.js-likes[data-like="'+ this.dataset.like +'"]')
  axios.get(url).then(function(response){
    spanCount.textContent = response.data.likes
  })
}
document.querySelectorAll('a.js-like').forEach(function(link){
  link.addEventListener('click',onClickBtnLike);
})
