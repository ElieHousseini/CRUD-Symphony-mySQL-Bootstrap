const articles = document.getElementById("articles")

if (articles) {
  // On click of the delete button
  // I want to do a confirmation
  // then delete the article from the table
  // according to the article ID
  // Then reload the page
  articles.addEventListener("click", (e) => {
    if (e.target.className === "btn btn-danger delete-article") {
      if (confirm("Are you sure ?")) {
        const id = e.target.getAttribute("data-id")
        fetch(`/article/delete/${id}`, {
          method: "DELETE",
        }).then((res) => window.location.reload())
      }
    }
  })
}
