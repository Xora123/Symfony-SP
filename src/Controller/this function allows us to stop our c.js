// this function allows us to stop our code for |ms| milliseconds.
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

// I've put our main code into this function.
async function addPeople() {
  ul = document.querySelectorAll('.discover-fluid-entity-list.discover-fluid-entity-list--default-width-cards')[3]
  firstLi = ul.querySelector('li');
  count = 0; // this is the count of how many people you've added
  while(firstLi && count < 100){ // stop after adding 100 people
    buttonToClick = firstLi.querySelector(".artdeco-button.artdeco-button--2.artdeco-button--secondary.ember-view.full-width");
    // make sure that this button contains the text "Connect"
    if (buttonToClick.innerText.includes("Se connecter")){
      buttonToClick.click();
      count += 1;
      console.log("I have added " + count + " people so far.");
    }
    ul.removeChild(firstLi);
    await sleep(1000); // stop this function for 1 second here.
    firstLi = ul.querySelector('li');
  }
}

addPeople();