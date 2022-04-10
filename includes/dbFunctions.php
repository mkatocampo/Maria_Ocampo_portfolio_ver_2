<?php

//blogs
function allBlogs($conn, $categoryId, $tagId){
    $sql = "SELECT 
                blogs.id, blogs.title, blogs.teaser, blogs.blog_text, blogs.created_at, 
                categories_to_blog.category_id, categories.category,
                tags_to_blog.tag_id, tags.tag
            FROM categories,tags,blogs
                LEFT OUTER JOIN categories_to_blog ON categories_to_blog.blog_id = blogs.id
                LEFT OUTER JOIN tags_to_blog ON tags_to_blog.blog_id = blogs.id
            WHERE
                categories_to_blog.category_id = categories.id AND
                tags_to_blog.tag_id = tags.id AND
                categories_to_blog.category_id = IF($categoryId = '', category_id, $categoryId) AND
                tags_to_blog.tag_id=IF($tagId = '', tag_id, $tagId)";
                
    $stmt = $conn->query($sql);
    return $stmt;
}

function getBlogDetails($conn,$id){
    $sql = "SELECT 
                blogs.id, blogs.title, blogs.teaser, blogs.blog_text, blogs.created_at, 
                categories_to_blog.category_id, categories.category,
                tags_to_blog.tag_id, tags.tag,
                images_to_blog.image_id, images.filepath
            FROM categories,tags,images,blogs
                LEFT OUTER JOIN categories_to_blog ON categories_to_blog.blog_id = blogs.id
                LEFT OUTER JOIN tags_to_blog ON tags_to_blog.blog_id = blogs.id
                LEFT OUTER JOIN images_to_blog ON images_to_blog.blog_id = blogs.id
            WHERE
                categories_to_blog.category_id = categories.id AND
                tags_to_blog.tag_id = tags.id AND
                images_to_blog.image_id = images.id AND
                blogs.id = $id";
                
    $stmt=$conn->query($sql) or die("Problem with query");
    return $stmt->fetch_assoc();

    $stmt->close();
}

function getBlogImages($conn,$id){
    $sql = "SELECT * FROM images_to_blog, images 
        WHERE images.id = images_to_blog.image_id AND blog_id = $id";
            
    $stmt = $conn->query($sql);
    return $stmt;
}

function addBlogPost($conn,$title,$teaser,$blog_text,$categoryId,$tagId, $images){
    $sql="INSERT INTO blogs(title, teaser, blog_text) VALUES (?,?,?)";
            
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('sss',$title,$teaser,$blog_text);
    $stmt->execute();

    $id = $conn->insert_id;

    if ($categoryId != null){
        $sql = "INSERT INTO categories_to_blog (categories_to_blog.blog_id, categories_to_blog.category_id) VALUES (?, ?)";
        $stmt=$conn->prepare($sql) or die("Problem with query");
        $stmt->bind_param('ii',$id,$categoryId);
        $stmt->execute();
    }

    if ($tagId != null){
        $sql = "INSERT INTO tags_to_blog (tags_to_blog.blog_id, tags_to_blog.tag_id) VALUES (?, ?)";
        $stmt=$conn->prepare($sql) or die("Problem with query");
        $stmt->bind_param('ii',$id,$tagId);
        $stmt->execute();
    }

    if ($images != null){
        foreach($images as $imageId){
            $sql = "INSERT INTO images_to_blog (images_to_blog.blog_id, images_to_blog.image_id) VALUES (?, ?)";
            $stmt=$conn->prepare($sql) or die("Problem with query");
            $stmt->bind_param('ii',$id,$imageId);
            $stmt->execute();
        }
    }

    return $id;

    $stmt->close();
}

function updateBlogPost($conn,$title,$teaser,$blog_text,$categoryId,$tagId,$images,$id){

    $sql="UPDATE blogs
            INNER JOIN categories_to_blog ON categories_to_blog.blog_id = blogs.id
            INNER JOIN tags_to_blog ON tags_to_blog.blog_id = blogs.id
        SET blogs.title=?, blogs.teaser=?, blogs.blog_text=?, categories_to_blog.category_id=?, tags_to_blog.tag_id=?
        WHERE blogs.id=?";
    
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('sssiii',$title,$teaser,$blog_text,$categoryId,$tagId,$id);
    $stmt->execute();

    deleteImageFromBlog($conn,$id);

    if ($images != null){
        foreach($images as $imageId){
            $sql = "INSERT INTO images_to_blog (images_to_blog.blog_id, images_to_blog.image_id) VALUES (?, ?)";
            $stmt=$conn->prepare($sql) or die("Problem with query");
            $stmt->bind_param('ii',$id,$imageId);
            $stmt->execute();
        }
    }

    return $stmt->affected_rows;

    $stmt->close();
}

function deleteBlogPost($conn,$id){
    $sql="DELETE FROM `blogs` WHERE `id`=?";
    
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    return $stmt->affected_rows;

    $stmt->close();
}

function redirectTo($location = NULL){
    if($location != NULL){
        header("Location: $location");
        exit;
    }
}

function validateLogin($conn,$username,$password){
    $sql="SELECT * FROM users WHERE username=? AND password=?";
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();

    $username = $stmt->fetch();

    if ($username) {
        return true;
    } else {
        return false;
    } 
}

function addImage($conn,$image){
    $sql="INSERT INTO images(image, filepath) VALUES (?,?)";
            
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('ss',$image,$image);
    $stmt->execute();

    $id = $conn->insert_id;

    return $id;

    $stmt->close();
}

//projects
function allProjs($conn, $categoryId, $tagId){
    $sql = "SELECT 
                projects.id, projects.title, projects.teaser, projects.proj_text, projects.created_at, 
                categories_to_project.category_id, categories.category,
                tags_to_project.tag_id, tags.tag
            FROM categories,tags,projects
                LEFT OUTER JOIN categories_to_project ON categories_to_project.project_id = projects.id
                LEFT OUTER JOIN tags_to_project ON tags_to_project.project_id = projects.id
            WHERE
                categories_to_project.category_id = categories.id AND
                tags_to_project.tag_id = tags.id AND
                categories_to_project.category_id = IF($categoryId = '', category_id, $categoryId) AND
                tags_to_project.tag_id=IF($tagId = '', tag_id, $tagId)";
                
    $stmt = $conn->query($sql);
    return $stmt;
}

function addProj($conn,$title,$teaser,$proj_text,$categoryId,$tagId,$images){
    $sql="INSERT INTO projects(title, teaser, proj_text) VALUES (?,?,?)";
            
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('sss',$title,$teaser,$proj_text);
    $stmt->execute();

    $id = $conn->insert_id;

    if ($categoryId != null){
        $sql = "INSERT INTO categories_to_project (categories_to_project.project_id, categories_to_project.category_id) VALUES (?, ?)";
        $stmt=$conn->prepare($sql) or die("Problem with query");
        $stmt->bind_param('ii',$id,$categoryId);
        $stmt->execute();
    }

    if ($tagId != null){
        $sql = "INSERT INTO tags_to_project (tags_to_project.project_id, tags_to_project.tag_id) VALUES (?, ?)";
        $stmt=$conn->prepare($sql) or die("Problem with query");
        $stmt->bind_param('ii',$id,$tagId);
        $stmt->execute();
    }

    if ($images != null){
        foreach($images as $imageId){
            $sql = "INSERT INTO images_to_project (images_to_project.project_id, images_to_project.image_id) VALUES (?, ?)";
            $stmt=$conn->prepare($sql) or die("Problem with query");
            $stmt->bind_param('ii',$id,$imageId);
            $stmt->execute();
        }
    }

    return $id;

    $stmt->close();
}

function getProjDetails($conn,$id){
    $sql = "SELECT 
                projects.id, projects.title, projects.teaser, projects.proj_text, projects.created_at, 
                categories_to_project.category_id, categories.category,
                tags_to_project.tag_id, tags.tag,
                images_to_project.image_id, images.filepath
            FROM categories,tags,images,projects
                LEFT OUTER JOIN categories_to_project ON categories_to_project.project_id = projects.id
                LEFT OUTER JOIN tags_to_project ON tags_to_project.project_id = projects.id
                LEFT OUTER JOIN images_to_project ON images_to_project.project_id = projects.id
            WHERE
                categories_to_project.category_id = categories.id AND
                tags_to_project.tag_id = tags.id AND
                images_to_project.image_id = images.id AND
                projects.id = $id";
                
    $stmt=$conn->query($sql) or die("Problem with query");
    return $stmt->fetch_assoc();

    $stmt->close();
}

function getLatestProjects($conn){
    $sql = "SELECT * FROM projects ORDER BY id DESC LIMIT 5";

    $stmt = $conn->query($sql);
    return $stmt;
}

function getProjImages($conn,$id){
    $sql = "SELECT * FROM images_to_project, images 
        WHERE images.id = images_to_project.image_id AND project_id = $id";
            
    $stmt = $conn->query($sql);
    return $stmt;
}

function updateProj($conn,$title,$teaser,$proj_text,$categoryId,$tagId,$images,$id){

    $sql="UPDATE projects
            INNER JOIN categories_to_project ON categories_to_project.project_id = projects.id
            INNER JOIN tags_to_project ON tags_to_project.project_id = projects.id
        SET projects.title=?, projects.teaser=?, projects.proj_text=?, categories_to_project.category_id=?, tags_to_project.tag_id=?
        WHERE projects.id=?";
    
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('sssiii',$title,$teaser,$proj_text,$categoryId,$tagId,$id);
    $stmt->execute();

    deleteImageFromProj($conn,$id);

    if ($images != null){
        foreach($images as $imageId){
            $sql = "INSERT INTO images_to_project (images_to_project.project_id, images_to_project.image_id) VALUES (?, ?)";
            $stmt=$conn->prepare($sql) or die("Problem with query");
            $stmt->bind_param('ii',$id,$imageId);
            $stmt->execute();
        }
    }

    return $stmt->affected_rows;

    $stmt->close();
}

function deleteProj($conn,$id){
    $sql="DELETE FROM `projects` WHERE `id`=?";
    
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    return $stmt->affected_rows;

    $stmt->close();
}

function deleteImageFromProj($conn,$id){
    $sql="DELETE FROM images_to_project WHERE project_id=?";
    
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    return $stmt->affected_rows;

    $stmt->close();
}

function deleteImageFromBlog($conn,$id){
    $sql="DELETE FROM images_to_blog WHERE blog_id=?";
    
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    return $stmt->affected_rows;

    $stmt->close();
}

function deleteImage($conn,$id){
    $sql="DELETE FROM images WHERE id=?";
    
    $stmt=$conn->prepare($sql) or die("Problem with query");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    return $stmt->affected_rows;

    $stmt->close();
}