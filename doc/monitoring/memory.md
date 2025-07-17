# memory

To check memory usage `memory_get_usage`

## Main blocks are ready

Date    - 17.07.25
Method  - memory_get_usage(true)
Page    - /
PHP     - 8.4.10
X-Debug - on

| Points   |  usage (mb)   | symfony |  description          |
|----------|:-------------:|-------- |-----------------------|
|  # 1     |    2.09       |   8.38  |  after vendor/autoload|
|  # 2     |    2.09       |   -     |                       |
|  # 3     |    2.09       |   -     |                       |
|  # 4     |    4.19       |  25.16  | inside a cntroller    |
|  # 5     |    4.19       |   4.19  | kernel terminate      |

The project was used for comparison - [see on github](https://github.com/Romchik38/learning_doctrine)