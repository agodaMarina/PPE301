// const collectionHolder = document.querySelector('#commande_achat_articles');
// let index =collectionHolder.querySelectorAll("div").length;

// const addArticle = () =>{

//     console.log(index);
//     collectionHolder.innerHTML += collectionHolder.dataset.prototypereplace(/__name__/g,index);
//     index++;

//     }
// document.querySelector('#new-article').addEventListener('click', addArticle);

//ajouter une nouvelle ligne
const nouvelleLigne = (e) => {
    const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);

    const item = document.createElement("tr");

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index);

    item.querySelector(".btn-remove").addEventListener("click", ()=>item.remove());

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
     

};

//supprimer la ligne 
 
document
    .querySelectorAll('.btn-remove')
    .forEach(btn => btn.addEventListener("click", (e) => e.currentTarget.closest('.item').remove()));

document
    .querySelectorAll('.btn-new')
    .forEach(btn => btn.addEventListener("click", nouvelleLigne));

