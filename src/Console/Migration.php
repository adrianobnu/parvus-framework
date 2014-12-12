<?php
    namespace Parvus\Commands;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Formatter\OutputFormatterStyle;

    class MigrationCommand extends Command
    {

        protected function configure()
        {

            $this
                ->setName("Parvus:Migration")
                ->setDescription("Create a new migration")
                ->setDefinition(array (
                    new InputOption('name', 'name', InputOption::VALUE_REQUIRED, 'The name of migration', NULL)
                ))
                ->setHelp(
                    "Create a database migration

                    Usage:
                    <info>php console.php Parvus:Migration --name MIGRATION_NAME</info>");
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $name = $input->getOption('name');

            if ($name == NULL)
            {
                throw new \InvalidArgumentException('Please define the migration name.');
            }

            /** Create the folders */
            @mkdir (path.'app/database/',0775);
            @mkdir (path.'app/database/migration/',0775);
            @mkdir (path.'app/database/seed/',0775);

            $content = '<?php'.chr(10).chr(10);
                $content.= chr(9).'use Illuminate\Database\Migrations\Migration;'.chr(10).chr(10);

                $content.= chr(9).'class CreateTableOrganizacao extends Migration'.chr(10);
                $content.= chr(9).'{'.chr(10).chr(10);

                    $content.= chr(9).chr(9).'/** Run the migration */'.chr(10);
                    $content.= chr(9).chr(9).'public final function up ()'.chr(10);
                    $content.= chr(9).chr(9).'{'.chr(10).chr(10);
                    $content.= chr(9).chr(9).'}'.chr(10).chr(10);

                    $content.= chr(9).chr(9).'/** Reverse the migration */'.chr(10);
                    $content.= chr(9).chr(9).'public final function down ()'.chr(10);
                    $content.= chr(9).chr(9).'{'.chr(10).chr(10);
                    $content.= chr(9).chr(9).'}'.chr(10).chr(10);

                $content.= chr(9).'}';

            $this->file(path.'app/database/migration/',$name.'.php',$content);

            $output->writeln('Migration sucess create: '.$name);
        }

        private final function file ($prDirectory,$prName,$prContent)
        {
            if (file_exists($prDirectory.$prName))
            {
                @unlink($prDirectory.$prName);
            }

            $file = fopen($prDirectory.$prName,'w+');
            fwrite($file,$prContent);
            fclose($file);

            chmod($prDirectory.$prName,0775);
        }
    }