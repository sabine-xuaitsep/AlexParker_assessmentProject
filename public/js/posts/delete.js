/* 
  ./public/js/posts/delete.js
    AJAX request
*/


const action = confirm("Your post will be permanently deleted!");

if(action === false) {
  window.history.back();
}

else {

  const postID = document.getElementById('postID').value;

  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  
  axios.post(`?posts=delete&id=${postID}&confirmed=ok`)
  .then(function (response) {
    // console.log(response);
    window.location.assign(`index`);

  })
  .catch(function (error) {
    // console.log(error);
    alert("Deletion not executed! You will be redirected to the previous page.");
    window.history.back();
  })
  .then(function () {
    // always executed
  });
}
