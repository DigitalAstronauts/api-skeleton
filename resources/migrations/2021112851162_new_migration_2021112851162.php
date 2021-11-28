<?php 
class NewMigration2021112851162 extends Phinx\Migration\AbstractMigration
{
	public function change(): void
	{
		$table = $this->table('author', ['signed' => false]);
		$table->addColumn('name', 'string', []);
		$table->save();
	}
}
