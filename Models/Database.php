<?php
require_once ('Models/Product.php');
require_once ('Models/Category.php');
require_once ('Models/UserDatabase.php');
require_once ('vendor/autoload.php');
class DBContext
{

    private $pdo;
    private $usersDatabase;

    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }

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
        $this->usersDatabase = new UserDatabase($this->pdo);
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
        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();

        $initialized = true;
    }

    function getPopularProducts($sortCol, $sortOrder, $q)
    {
        return $this->pdo->query('SELECT * FROM products ORDER BY stockLevel ASC limit 10')->fetchAll(
            PDO::FETCH_CLASS,
            'Product'
        );
    }

    function searchProducts($sortCol, $sortOrder, $q, $categoryId, $pageNo = 1, $pageSize = 5)
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
            $sql = $sql . " ( title like :q";
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

        $sqlCount = str_replace("SELECT * FROM", "SELECT CEIL (COUNT(*)/$pageSize) FROM ", $sql);

        $offset = ($pageNo - 1) * $pageSize;
        $sql .= " limit $offset, $pageSize";
        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute($paramsArray);
        $data = $prep->fetchAll();

        $prep2 = $this->pdo->prepare($sqlCount);
        $prep2->execute($paramsArray);

        $num_pages = $prep2->fetchColumn();

        $arr = ["data" => $data, "num_pages" => $num_pages];
        return $arr;
    }
}

?>