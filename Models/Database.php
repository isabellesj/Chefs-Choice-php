<?php
require_once ('Models/Product.php');
require_once ('Models/Category.php');
require_once ('Models/UserDatabase.php');
require_once ('vendor/autoload.php');
class DBContext
{

    private $pdo;
    // private $usersDatabase; //till inlogg

    // function getUsersDatabase() //till inlogg
    // {
    //     return $this->usersDatabase;
    // }

    function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
        $host = $_ENV['host'];
        $db = $_ENV['db'];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        // $this->usersDatabase = new UserDatabase($this->pdo);
        $this->initIfNotInitialized();
        $this->seedIfNotSeeded();
    }

    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');

    }

    function getAllProducts()
    {
        return $this->pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
    function getProduct($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function getProductByTitle($title)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }

    function getCategoryByTitle($title): Category|false
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }

    function getCategory($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }

    function seedIfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;
        $this->createIfNotExisting('Seedless Grapes', './assets/grapes.svg', 18, 39, 'Fruits');
        $this->createIfNotExisting('Lemon', './assets/lemon.svg', 19, 17, 'Fruits');
        $this->createIfNotExisting('Cocktail Tomatoes', './assets/tomatoes.svg', 10, 13, 'Vegetables');
        $this->createIfNotExisting('Apple Granny Smith', './assets/apple.svg', 22, 53, 'Fruits');
        $this->createIfNotExisting('Gouda Cheese', './assets/cheese.svg', 21, 0, 'Dairy');
        $this->createIfNotExisting('Ground Chicken', './assets/chicken.svg', 25, 120, 'Meat/Poultry');
        $this->createIfNotExisting('Chicken Ham', './assets/chickenham.svg', 30, 15, 'Meat/Poultry');
        $this->createIfNotExisting('Trocadero 33cl', './assets/trocadero.svg', 40, 6, 'Soda');
        $this->createIfNotExisting('Cuba Cola 33cl', './assets/cubacola.svg', 97, 29, 'Soda');
        $this->createIfNotExisting('Brioche Bread', './assets/brioche.svg', 31, 31, 'Bread');
        $this->createIfNotExisting('Magnum Almond', './assets/magnumalmond.svg', 21, 22, 'Frozen');
        $this->createIfNotExisting('Pan Pizza Vesuvio', './assets/vesuvio.svg', 38, 86, 'Frozen');
        $this->createIfNotExisting('Burger 4-pack', './assets/burger.svg', 6, 24, 'Meat/Poultry');
        $this->createIfNotExisting('Spareribs', './assets/spareribs.svg', 22, 35, 'Meat/Poultry');
        $this->createIfNotExisting('Milda Butter', './assets/mildabutter.svg', 18, 39, 'Dairy');
        $this->createIfNotExisting('Milda Culiness', './assets/mildaculiness.svg', 12, 29, 'Dairy');
        $this->createIfNotExisting('Sugar Snaps', './assets/sugarsnaps.svg', 39, 0, 'Vegetables');
        $this->createIfNotExisting('Aubergine', './assets/aubergine.svg', 231, 42, 'Vegetables');
        $this->createIfNotExisting('Crispy Nuggets', './assets/nuggets.svg', 213, 25, 'Frozen');
        $this->createIfNotExisting('Chicken Kebab', './assets/chickenkebab.svg', 81, 40, 'Frozen');
        // $this->createIfNotExisting('Sir Rodneys Scones', 10, 3, 'Confections');
        // $this->createIfNotExisting('Gustafs Knäckebröd', 21, 104, 'Grains/Cereals');
        // $this->createIfNotExisting('Tunnbröd', 9, 61, 'Grains/Cereals');
        // $this->createIfNotExisting('Guaraná Fantástica', 231, 20, 'Beverages');
        // $this->createIfNotExisting('NuNuCa Nuß-Nougat-Creme', 14, 76, 'Confections');
        // $this->createIfNotExisting('Gumbär Gummibärchen', 312, 15, 'Confections');
        // $this->createIfNotExisting('Schoggi Schokolade', 213, 49, 'Confections');
        // $this->createIfNotExisting('Rössle Sauerkraut', 132, 26, 'Produce');
        // $this->createIfNotExisting('Thüringer Rostbratwurst', 231, 0, 'Meat/Poultry');
        // $this->createIfNotExisting('Nord-Ost Matjeshering', 321, 10, 'Seafood');
        // $this->createIfNotExisting('Gorgonzola Telino', 321, 0, 'Dairy Products');
        // $this->createIfNotExisting('Mascarpone Fabioli', 32, 9, 'Dairy Products');
        // $this->createIfNotExisting('Geitost', 12, 112, 'Dairy Products');
        // $this->createIfNotExisting('Sasquatch Ale', 14, 111, 'Beverages');
        // $this->createIfNotExisting('Steeleye Stout', 18, 20, 'Beverages');
        // $this->createIfNotExisting('Inlagd Sill', 19, 112, 'Seafood');
        // $this->createIfNotExisting('Gravad lax', 26, 11, 'Seafood');
        // $this->createIfNotExisting('Côte de Blaye', 1, 17, 'Beverages');
        // $this->createIfNotExisting('Chartreuse verte', 18, 69, 'Beverages');
        // $this->createIfNotExisting('Boston Crab Meat', 2, 123, 'Seafood');
        // $this->createIfNotExisting('Jacks New England Clam Chowder', 2, 85, 'Seafood');
        // $this->createIfNotExisting('Singaporean Hokkien Fried Mee', 14, 26, 'Grains/Cereals');
        // $this->createIfNotExisting('Ipoh Coffee', 46, 17, 'Beverages');
        // $this->createIfNotExisting('Gula Malacca', 2, 27, 'Condiments');
        // $this->createIfNotExisting('Rogede sild', 3, 5, 'Seafood');
        // $this->createIfNotExisting('Spegesild', 12, 95, 'Seafood');
        // $this->createIfNotExisting('Zaanse koeken', 4, 36, 'Confections');
        // $this->createIfNotExisting('Chocolade', 6, 15, 'Confections');
        // $this->createIfNotExisting('Maxilaku', 5, 10, 'Confections');
        // $this->createIfNotExisting('Valkoinen suklaa', 1, 65, 'Confections');
        // $this->createIfNotExisting('Manjimup Dried Apples', 53, 20, 'Produce');
        // $this->createIfNotExisting('Filo Mix', 7, 38, 'Grains/Cereals');
        // $this->createIfNotExisting('Perth Pasties', 4, 0, 'Meat/Poultry');
        // $this->createIfNotExisting('Tourtière', 7, 21, 'Meat/Poultry');
        // $this->createIfNotExisting('Pâté chinois', 24, 115, 'Meat/Poultry');
        // $this->createIfNotExisting('Gnocchi di nonna Alice', 38, 21, 'Grains/Cereals');
        // $this->createIfNotExisting('Ravioli Angelo', 7, 36, 'Grains/Cereals');
        // $this->createIfNotExisting('Escargots de Bourgogne', 7, 62, 'Seafood');
        // $this->createIfNotExisting('Raclette Courdavault', 55, 79, 'Dairy Products');
        // $this->createIfNotExisting('Camembert Pierrot', 34, 19, 'Dairy Products');
        // $this->createIfNotExisting('Sirop dérable', 7, 113, 'Condiments');
        // $this->createIfNotExisting('Tarte au sucre', 7, 17, 'Confections');
        // $this->createIfNotExisting('Vegie-spread', 7, 24, 'Condiments');
        // $this->createIfNotExisting('Wimmers gute Semmelknödel', 7, 22, 'Grains/Cereals');
        // $this->createIfNotExisting('Louisiana Fiery Hot Pepper Sauce', 7, 76, 'Condiments');
        // $this->createIfNotExisting('Louisiana Hot Spiced Okra', 17, 4, 'Condiments');
        // $this->createIfNotExisting('Laughing Lumberjack Lager', 14, 52, 'Beverages');
        // $this->createIfNotExisting('Scottish Longbreads', 8, 6, 'Confections');
        // $this->createIfNotExisting('Gudbrandsdalsost', 8, 26, 'Dairy Products');
        // $this->createIfNotExisting('Outback Lager', 15, 15, 'Beverages');
        // $this->createIfNotExisting('Flotemysost', 8, 26, 'Dairy Products');
        // $this->createIfNotExisting('Mozzarella di Giovanni', 8, 14, 'Dairy Products');
        // $this->createIfNotExisting('Röd Kaviar', 15, 101, 'Seafood');
        // $this->createIfNotExisting('Longlife Tofu', 10, 4, 'Produce');
        // $this->createIfNotExisting('Rhönbräu Klosterbier', 9, 125, 'Beverages');
        // $this->createIfNotExisting('Lakkalikööri', 9, 57, 'Beverages');
        // $this->createIfNotExisting('Original Frankfurter grüne Soße', 13, 32, 'Condiments');

        $seeded = true;

    }

    function createIfNotExisting($title, $image, $price, $stockLevel, $categoryName)
    {
        $existing = $this->getProductByTitle($title);
        if ($existing) {
            return;
        }
        ;
        return $this->addProduct($title, $image, $price, $stockLevel, $categoryName);

    }

    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title" => $title]);
        return $this->pdo->lastInsertId();
    }


    function addProduct($title, $image, $price, $stockLevel, $categoryName)
    {

        $category = $this->getCategoryByTitle($categoryName);
        if ($category == false) {
            $this->addCategory($categoryName);
            $category = $this->getCategoryByTitle($categoryName);
        }


        //insert plus get new id 
        // return id             
        $prep = $this->pdo->prepare('INSERT INTO products (title, image, price, stockLevel, categoryId) VALUES(:title, :image, :price, :stockLevel, :categoryId )');
        $prep->execute(["title" => $title, "image" => $image, "price" => $price, "stockLevel" => $stockLevel, "categoryId" => $category->id]);
        return $this->pdo->lastInsertId();

    }

    function initIfNotInitialized()
    {

        static $initialized = false;
        if ($initialized)
            return;


        $sql = "CREATE TABLE IF NOT EXISTS `category` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
            ) ";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            `image` varchar(200) NOT NULL,
            `price` INT,
            `stockLevel` INT,
            `categoryId` INT NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
                REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $initialized = true;
    }

    //POPULÄRA PRODUKTER:
    function getPopularProducts($sortCol, $sortOrder, $q)
    {
        return $this->pdo->query('SELECT * FROM products ORDER BY stockLevel ASC limit 10')->fetchAll(
            PDO::FETCH_CLASS,
            'Product'
        );
    }

    function searchProducts($sortCol, $sortOrder, $q, $categoryId, $pageNo = 1, $pageSize = 20)
    {
        if ($sortCol == null) {
            $sortCol = "Id";
        }
        if ($sortOrder == null) {
            $sortOrder = "asc";
        }
        $sql = "SELECT * FROM products ";
        $paramsArray = [];
        $addedWhere = false;
        if ($q != null && strlen($q) > 0) {

            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " ( title like :q"; //spelar ordningen roll?
            $sql = $sql . " OR categoryId like :q";
            $sql = $sql . " OR price like :q";
            $sql = $sql . " OR stockLevel like :q )";
            $paramsArray["q"] = '%' . $q . '%';
        }

        if ($categoryId != null && strlen($categoryId) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " ( CategoryId = :categoryId )";
            $paramsArray["categoryId"] = $categoryId;

        }


        $sql .= " ORDER BY $sortCol $sortOrder ";

        $sqlCount = str_replace("SELECT * FROM ", "SELECT CEIL (COUNT(*)/$pageSize) FROM ", $sql);

        // $pageNo = 1, $pageSize = 20
        $offset = ($pageNo - 1) * $pageSize;
        $sql .= " limit $offset, $pageSize";

        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute($paramsArray);
        $data = $prep->fetchAll(); // arrayen
        // return $data;

        $prep2 = $this->pdo->prepare($sqlCount);
        $prep2->execute($paramsArray);

        $num_pages = $prep2->fetchColumn(); // antal sidor tex 3

        $arr = ["data" => $data, "num_pages" => $num_pages];
        return $arr;
    }
}

?>