<form action="<?php echo $form_action; ?>" method="post" >
    <fieldset>
        <legend>Book Information</legend>

        <label for="title">Title*</label>
        <input type="text" id="title" name="title" value="<?php echo set_value("title", $book_data['title'])?>"> 
        </br >
                
       <label for="author">Author*</label>
        <input type="text" id="author" name="author" value="<?php echo set_value("author", $book_data['author'])?>"> 
        </br >

        <label for="price">Price*</label>
        <input type="text" id="price" name="price" value="<?php echo set_value("price", $book_data['price'])?>"> 
        </br >
        
        <label for="course">Course*</label>
        <input type="text" id="course" name="course" value="<?php echo set_value("course", $book_data['course'])?>"> 
        </br >
        
        <label for="description">Description*</label>
        <input type="text" id="description" name="description" value="<?php echo set_value("description", $book_data['description'])?>"> 
        </br >       
</form> 
            
                