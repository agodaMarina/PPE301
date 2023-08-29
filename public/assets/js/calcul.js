const calcul = () => {
    const index =document.querySelectorAll("tbody>tr").length;
    // const i = index.querySelector("trtd");
    // console.log(index);
    let vraiIndex= index-1;
    const indexQuantite= "commande_achat_ligneCommande_"+vraiIndex+"_quantite";
    const indexPrix= "commande_achat_ligneCommande_"+vraiIndex+"_prixUnitaire";
    const indextotal= "commande_achat_ligneCommande_"+vraiIndex+"_totalLigne";
    var q = document
        .getElementById(indexQuantite).value;
    var p = document
        .getElementById(indexPrix).value;
    var pp = document
        .getElementById(indextotal);
    const v=document.createElement("p")
    var prixhtLigne = q * p;
    console.log(q);
    console.log(p);
    v.innerHTML=prixhtLigne;
    document.pp.appendChild(v);
    console.log(pp);
    
    
    
};

document
    .querySelectorAll('.btn-valide')
    .forEach(btn => btn.addEventListener("click", calcul));
