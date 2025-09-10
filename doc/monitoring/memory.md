# Memory usage

To check memory usage, `memory_get_usage` function was used.

## Main blocks are ready

- Date    - 17.07.25
- Method  - memory_get_usage(true)
- Page    - /
- PHP     - 8.4.10
- X-Debug - on

| Points | Site2 (mb) | Symfony (mb) |     description            |
|--------|------------|--------------|----------------------------|
|  # 1   |    2.09    |     8.38     | after vendor/autoload      |
|  # 2   |    2.09    |     -        | DI conrainer is ready      |
|  # 3   |    2.09    |     -        | Server & Request are ready |
|  # 4   |    4.19    |    25.16     | inside a controller        |
|  # 5   |    4.19    |     4.19     | Kernel terminate           |

The Simfony project was used for comparison you can [see on github](https://github.com/Romchik38/learning_doctrine)

Site2 points:

- point # 1 [index.php line 10](./../../public/http/index.php)
- point # 2 [index.php line 16](./../../public/http/index.php)
- point # 3 [index.php line 41](./../../public/http/index.php)
- point # 4 [home action line 45](./../../app/code/Infrastructure/Http/Actions/GET/Root/DefaultAction.php)
- point # 5 [index.php line 46](./../../public/http/index.php)